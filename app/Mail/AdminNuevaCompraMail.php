<?php

namespace App\Mail;

use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\TipoViaje;
use App\Models\Plan;
use App\Models\Tarifa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNuevaCompraMail extends Mailable
{
    use Queueable, SerializesModels;

    public Cotizacion $cotizacion;
    public array $pasajerosData;
    public ?Plan $plan;
    public ?Tarifa $tarifa;
    public string $moneda;
    public ?string $destinoNombre = null;
    public ?string $tipoViajeNombre = null;
    public string $paisNombre;

    public function __construct(Cotizacion $cotizacion, array $pasajerosData = [], ?Plan $plan = null, ?Tarifa $tarifa = null)
    {
        $this->cotizacion = $cotizacion->loadMissing('pasajeros');
        $this->pasajerosData = $pasajerosData;
        $this->plan = $plan;
        $this->tarifa = $tarifa;

        $code = strtoupper($this->cotizacion->pais_origen ?? 'CO');
        $this->moneda = $code === 'CO' ? 'COP' : 'USD';

        // nombres de apoyo (por si no hay relaciones en el modelo)
        $this->destinoNombre = optional(Destino::find($this->cotizacion->destino_id))->nombre;
        $this->tipoViajeNombre = optional(TipoViaje::find($this->cotizacion->tipo_viaje_id))->nombre;

        $map = [
            'CO'=>'Colombia','AR'=>'Argentina','BO'=>'Bolivia','BR'=>'Brasil','CL'=>'Chile','EC'=>'Ecuador',
            'PY'=>'Paraguay','PE'=>'Perú','UY'=>'Uruguay','VE'=>'Venezuela','MX'=>'México','CR'=>'Costa Rica',
            'PA'=>'Panamá','GT'=>'Guatemala','SV'=>'El Salvador','HN'=>'Honduras','NI'=>'Nicaragua',
            'US'=>'Estados Unidos','CA'=>'Canadá','ES'=>'España','FR'=>'Francia','IT'=>'Italia','DE'=>'Alemania',
            'GB'=>'Reino Unido','PT'=>'Portugal','NL'=>'Países Bajos','BE'=>'Bélgica','CH'=>'Suiza',
        ];
        $this->paisNombre = $map[$code] ?? $code;
    }

    public function build()
    {
        $asunto = 'Nueva compra #' . $this->cotizacion->id . ' (' . $this->paisNombre . ')';

        return $this->subject($asunto)
            ->markdown('emails.admin.nueva-compra', [
                'cotizacion' => $this->cotizacion,
                'pasajerosData' => $this->pasajerosData,
                'plan' => $this->plan,
                'tarifa' => $this->tarifa,
                'moneda' => $this->moneda,
                'destinoNombre' => $this->destinoNombre,
                'tipoViajeNombre' => $this->tipoViajeNombre,
                'paisNombre' => $this->paisNombre,
            ]);
    }
}
