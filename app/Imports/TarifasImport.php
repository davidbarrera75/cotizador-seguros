<?php

namespace App\Imports;

use App\Models\Tarifa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TarifasImport implements ToCollection, WithHeadingRow
{
    public int $planId;
    public bool $dryRun;
    public int $maxRows;
    public array $report = [
        'processed' => 0,
        'valid'     => 0,
        'imported'  => 0,
        'skipped'   => 0,
        'errors'    => 0,
        'messages'  => [], // array de strings
    ];

    public function __construct(int $planId, bool $dryRun = false, int $maxRows = 10000)
    {
        $this->planId  = $planId;
        $this->dryRun  = $dryRun;
        $this->maxRows = $maxRows;
    }

    public function collection(Collection $rows)
    {
        $now    = now();
        $batch  = [];
        $seen   = []; // para detectar duplicados dentro del archivo por 'dias'

        foreach ($rows as $idx => $row) {
            $this->report['processed']++;

            if ($this->report['processed'] > $this->maxRows) {
                $this->report['errors']++;
                $this->report['messages'][] = "Se alcanzó el límite de {$this->maxRows} filas. Importación detenida.";
                break;
            }

            // Mapear encabezados alternativos
            $dias = $row['dias']
                ?? $row['dia']
                ?? $row['día']
                ?? $row['days']
                ?? $row['day']
                ?? null;

            $valor = $row['valor']
                ?? $row['precio']
                ?? $row['monto']
                ?? $row['amount']
                ?? null;

            // Normalizar
            $dias = is_numeric($dias) ? (int) $dias : (int) preg_replace('/[^\d-]/', '', (string) $dias);
            $precio = $this->toFloat($valor);

            // Validaciones
            if ($dias <= 0) {
                $this->report['errors']++;
                $this->report['messages'][] = "Fila ".($idx+2).": 'dias' inválido ({$dias}).";
                continue;
            }
            if ($precio <= 0) {
                $this->report['errors']++;
                $this->report['messages'][] = "Fila ".($idx+2).": 'valor' inválido ({$valor}).";
                continue;
            }

            // Duplicado dentro del archivo
            if (isset($seen[$dias])) {
                $this->report['skipped']++;
                $this->report['messages'][] = "Fila ".($idx+2).": duplicado de 'dias'={$dias} en el archivo (saltado).";
                continue;
            }
            $seen[$dias] = true;

            $this->report['valid']++;

            // En dry-run no escribimos
            if ($this->dryRun) {
                continue;
            }

            $batch[] = [
                'plan_id'    => $this->planId,
                'dias'       => $dias,
                'precio'     => $precio,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Escritura (si no es dry-run)
        if (!$this->dryRun && $batch) {
            // Requiere índice único (plan_id, dias)
            Tarifa::upsert($batch, ['plan_id','dias'], ['precio','updated_at']);
            $this->report['imported'] = count($batch);

            // Cache busting (si usas cache con tags es ideal)
            try {
                cache()->tags(['cotizador', "plan:{$this->planId}"])->flush();
            } catch (\Throwable $e) {
                // si tu store no soporta tags, omite
            }
        }
    }

    /** Normaliza "600.000,00", "600,000.00", "$80000" -> float */
    public function toFloat($value): float
    {
        if ($value === null) return 0.0;
        $v = (string) $value;
        $v = trim($v);
        // Quita símbolos de moneda, espacios y letras, deja dígitos + . ,
        $v = preg_replace('/[^\d.,-]/', '', $v);

        // Si hay coma y NO hay punto => asume coma decimal (ej. 600000,50)
        if (str_contains($v, ',') && !str_contains($v, '.')) {
            $v = str_replace(',', '.', $v);
        } else {
            // "600,000.50" -> quitar comas de miles
            $v = str_replace(',', '', $v);
        }
        return (float) $v;
    }

    public function getReport(): array
    {
        return $this->report;
    }
}
