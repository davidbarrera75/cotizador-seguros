<?php

namespace App\Services\Cotizador;

use App\Models\AppSetting;
use App\Models\Cotizacion;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuoteService
{
    /**
     * Moneda para el país de origen (CO -> COP, resto USD)
     */
    public function monedaParaPais(?string $iso2): string
    {
        $iso2 = strtoupper((string) $iso2);
        return $iso2 === 'CO' ? 'COP' : 'USD';
    }

    /**
     * Días de viaje (mínimo 1)
     */
    public function diasDeViaje(Cotizacion $c): int
    {
        $fs = $c->fecha_salida ? Carbon::parse($c->fecha_salida) : now();
        $fr = $c->fecha_regreso ? Carbon::parse($c->fecha_regreso) : $fs;
        
        // ✅ CORRECCIÓN: calcular desde fecha_salida hasta fecha_regreso
        return max(1, $fs->diffInDays($fr) + 1);
    }

    /**
     * Número de pasajeros en la cotización
     */
    public function numeroPasajeros(Cotizacion $c): int
    {
        return max(1, $c->pasajeros()->count());
    }

    /**
     * Edad máxima entre los pasajeros (0 si no hay)
     */
    public function edadMaxima(Cotizacion $c): int
    {
        return (int) ($c->pasajeros()->max('edad') ?? 0);
    }

    /**
     * Tasa USD/COP configurada (con piso pequeño para evitar división entre 0)
     */
    public function obtenerTasaUsdCop(): float
    {
        return max(0.0001, (float) AppSetting::usdCop());
    }

    /**
     * Convierte un precio en COP a la moneda destino (USD o COP)
     */
    public function convertirPrecio(float $precioBaseCop, string $monedaDestino, ?float $tasaUsdCop = null): float
    {
        $tasa = $tasaUsdCop ?? $this->obtenerTasaUsdCop();

        if ($monedaDestino === 'USD') {
            return $precioBaseCop / $tasa;
        }

        return $precioBaseCop; // ya está en COP
    }

    /**
     * Devuelve los planes compatibles con la cotización,
     * aplicando: filtro por destino/tipo/edad, selección de tarifa >= días,
     * descuento %, conversión de moneda y orden por precio final.
     *
     * Además añade a cada $plan propiedades calculadas:
     *  - precio_final
     *  - moneda
     *  - tarifa_id_aplicada
     *  - dias_tarifa
     *  - precio_sin_desc
     *  - descuento_aplicado
     *  - tasa_usd_cop
     *  - numero_pasajeros
     */
    public function planesParaCotizacion(Cotizacion $cotizacion): Collection
    {
        $moneda = $this->monedaParaPais($cotizacion->pais_origen);

        // IMPORTANTE: la llave de caché ahora incluye número de pasajeros
        $cacheKey = sprintf(
            'cotizador:planes:c:%d:m:%s:fs:%s:fr:%s:dest:%s:tipo:%s:edad:%d:pax:%d',
            $cotizacion->id,
            $moneda,
            (string) $cotizacion->fecha_salida,
            (string) $cotizacion->fecha_regreso,
            (string) $cotizacion->destino_id,
            (string) $cotizacion->tipo_viaje_id,
            $this->edadMaxima($cotizacion),
            $this->numeroPasajeros($cotizacion)
        );

        $ttl = (int) config('cotizador.cache_ttl', 10); // minutos

        return cache()->remember($cacheKey, now()->addMinutes($ttl), function () use ($cotizacion, $moneda) {
            $dias         = $this->diasDeViaje($cotizacion);
            $numeroPax    = $this->numeroPasajeros($cotizacion);
            $edadMx       = $this->edadMaxima($cotizacion);
            $tasaUsdCop   = $this->obtenerTasaUsdCop();

            $planes = Plan::query()
                ->where('activo', true)
                ->where('edad_maxima', '>=', $edadMx)
                ->when($cotizacion->destino_id, fn ($q) =>
                    $q->whereHas('destinos', fn ($qq) => $qq->where('destino_id', $cotizacion->destino_id))
                )
                ->when($cotizacion->tipo_viaje_id, fn ($q) =>
                    $q->whereHas('tiposViaje', fn ($qq) => $qq->where('tipo_viaje_id', $cotizacion->tipo_viaje_id))
                )
                ->with([
                    'aseguradora',
                    'tarifas' => fn ($q) => $q->where('dias', '>=', $dias)->orderBy('dias', 'asc'),
                ])
                ->get();

            foreach ($planes as $plan) {
                $tarifa = $plan->tarifas->first();   // primera tarifa que cumple >= días
                if (!$tarifa) {
                    continue; // si no hay tarifa aplicable, se descarta el plan
                }

                // ✅ CORRECCIÓN: Precio base de la tarifa × número de pasajeros
                $precioBaseCop = (float) $tarifa->precio * $numeroPax;

                // Aplicar descuento % del plan, si existe
                $descuento = (float) ($plan->descuento ?? 0);
                $precioSinDesc = $precioBaseCop;
                if ($descuento > 0) {
                    $precioBaseCop = max(0.0, $precioBaseCop - ($precioBaseCop * ($descuento / 100)));
                }

                // Convertir a la moneda de la cotización
                $precioConvertido = $this->convertirPrecio($precioBaseCop, $moneda, $tasaUsdCop);

                // Adjuntar datos calculados al modelo (para que la vista los use directamente)
                $plan->precio_final       = $precioConvertido;
                $plan->moneda             = $moneda;
                $plan->tarifa_id_aplicada = $tarifa->id;
                $plan->dias_tarifa        = $tarifa->dias; // días de la tarifa aplicada
                $plan->dias_cotizados     = $dias; // ✅ días reales del viaje
                $plan->precio_sin_desc    = $this->convertirPrecio($precioSinDesc, $moneda, $tasaUsdCop);
                $plan->descuento_aplicado = $descuento;
                $plan->tasa_usd_cop       = $tasaUsdCop;
                $plan->numero_pasajeros   = $numeroPax; // ✅ Para mostrar en la vista
            }

            // Filtrar los que sí tienen precio y ordenar por precio final ascendente
            return $planes
                ->filter(fn ($p) => isset($p->precio_final))
                ->sortBy('precio_final')
                ->values();
        });
    }

    /**
     * Si alguna vez quieres invalidar caché de una cotización en particular,
     * puedes recalcular la misma key de arriba y borrarla con cache()->forget($key).
     */
    public function bustCacheForCotizacion(Cotizacion $cotizacion): void
    {
        try {
            $moneda = $this->monedaParaPais($cotizacion->pais_origen);
            $key = sprintf(
                'cotizador:planes:c:%d:m:%s:fs:%s:fr:%s:dest:%s:tipo:%s:edad:%d:pax:%d',
                $cotizacion->id,
                $moneda,
                (string) $cotizacion->fecha_salida,
                (string) $cotizacion->fecha_regreso,
                (string) $cotizacion->destino_id,
                (string) $cotizacion->tipo_viaje_id,
                $this->edadMaxima($cotizacion),
                $this->numeroPasajeros($cotizacion)
            );
            cache()->forget($key);
        } catch (\Throwable $e) {
            // no-op
        }
    }
}