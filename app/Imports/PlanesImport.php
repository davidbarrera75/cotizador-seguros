<?php

namespace App\Imports;

use App\Models\Tarifa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithEvents;

class TarifasImport implements ToModel, WithHeadingRow, WithValidation, WithEvents
{
    use Importable;

    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Tarifa([
            'plan_id' => $this->planId,
            'dias' => $row['dias'],
            'precio' => $row['tarifa'], // Mapea 'tarifa' del Excel a 'precio' en BD
        ]);
    }

    /**
     * Registra eventos de la importación
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                // Eliminar todas las tarifas existentes del plan antes de importar
                Tarifa::where('plan_id', $this->planId)->delete();
            },
        ];
    }

    /**
     * Validación de los datos
     */
    public function rules(): array
    {
        return [
            'dias' => 'required|integer|min:1',
            'tarifa' => 'required|numeric|min:0',
        ];
    }

    /**
     * Mensajes de error personalizados
     */
    public function customValidationMessages()
    {
        return [
            'dias.required' => 'El campo días es obligatorio',
            'dias.integer' => 'El campo días debe ser un número entero',
            'tarifa.required' => 'El campo tarifa es obligatorio',
            'tarifa.numeric' => 'El campo tarifa debe ser un valor numérico',
        ];
    }

    /**
     * Especifica en qué fila empiezan los datos (después del encabezado)
     */
    public function headingRow(): int
    {
        return 1;
    }
}
