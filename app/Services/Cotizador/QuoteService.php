<?php

namespace App\Services\Cotizador;

use App\Models\AppSetting;
use App\Models\Cotizacion;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuoteService
{
    public function monedaParaPais(?string $iso2): string
    {
        $iso2 = strtoupper((string) $iso2);
        return $iso2 === 'CO' ? 'COP' : 'USD';
    }

    public function diasDeViaje(Cotizacion $c): int
    {
        $fs = $c->fecha_salida ? Carbon::parse($c->fecha_salida) : now();
        $fr = $c->fecha_regreso ? Carbon::parse($c->fecha_regreso) : $fs;
        return max(1, $fr->diffInDays($fs) + 1);
    }

    public function edadMaxima(Cotizacion $c): int
    {
        return (int) ($c->pasajeros()->max('edad') ?? 0);
    }

    public function obtenerTasaUsdCop(): float
    {
        return max(0.0001, (float) AppSetting::usdCop());
    }

    public function convertirPrecio(float $precioBaseCop, string $monedaDestino): float
    {
        if ($monedaDestino === 'USD') {
            return $precioBaseCop / $this->obtenerTasaUsdCop();
        }
        return $precioBaseCop;
    }

    public function planesParaCotizacion(Cotizacion $cotizacion): Collection
    {
        $moneda = $this->monedaParaPais($cotizacion->pais_origen);

        $cacheKey = sprintf(
            'cotizador:planes:cotizacion:%d:%s:%s:%s',
            $cotizacion->id,
            $moneda,
            (string) $cotizacion->updated_at?->timestamp,
            (string) $cotizacion->fecha_salida
        );

        $ttl = (int) config('cotizador.cache_ttl', 10);

        return cache()->remember($cacheKey, now()->addMinutes($ttl), function () use ($cotizacion, $moneda) {
            $dias   = $this->diasDeViaje($cotizacion);
            $edadMx = $this->edadMaxima($cotizacion);

            $planes = Plan::query()
                ->where('activo', true)
                ->where('edad_maxima', '>=', $edadMx)
                ->when($cotizacion->destino_id, fn($q) =>
                    $q->whereHas('destinos', fn($qq) => $qq->where('destino_id', $cotizacion->destino_id))
                )
                ->when($cotizacion->tipo_viaje_id, fn($q) =>
                    $q->whereHas('tiposViaje', fn($qq) => $qq->where('tipo_viaje_id', $cotizacion->tipo_viaje_id))
                )
                ->with([
                    'aseguradora',
                    'tarifas' => fn($q) => $q->where('dias', '>=', $dias)->orderBy('dias', 'asc'),
                ])
                ->get();

            foreach ($planes as $plan) {
                $tarifa = $plan->tarifas->first();
                if (!$tarifa) continue;

                $precioBaseCop    = (float) $tarifa->precio;
                $precioConvertido = $this->convertirPrecio($precioBaseCop, $moneda);

                $plan->precio_final       = $precioConvertido;
                $plan->moneda             = $moneda;
                $plan->tarifa_id_aplicada = $tarifa->id;
                $plan->dias_tarifa        = $tarifa->dias;
            }

            return $planes->filter(fn ($p) => isset($p->precio_final))->values();
        });
    }

    public function bustCacheForCotizacion(Cotizacion $cotizacion): void
    {
        try {
            cache()->tags(['cotizador', "cotizacion:{$cotizacion->id}"])->flush();
        } catch (\Throwable $e) {}
    }
}
