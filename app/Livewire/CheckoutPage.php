<?php

namespace App\Livewire;

use App\Mail\ConfirmacionCompraMail;
use App\Models\AppSetting;
use App\Models\Cotizacion;
use App\Models\Order;
use App\Models\Plan;
use App\Services\Cotizador\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Livewire\Component;

class CheckoutPage extends Component
{
    public Cotizacion $cotizacion;
    public ?Plan $plan = null;
    public array $pasajerosData = [];

    // ✅ Nuevas propiedades para el resumen
    public ?float $precioMostrado = null;
    public string $monedaMostrada = 'COP';
    public ?float $tasaUsdCop = null;

    public array $tiposDeDocumento = [
        'Cédula de ciudadanía','Cédula de extranjería','Pasaporte','Tarjeta de identidad',
    ];

    public array $paises = ['Colombia','Argentina','Brasil','Chile','Ecuador','España','Estados Unidos','México','Perú'];

    public function mount(Cotizacion $cotizacion, Request $request, QuoteService $quotes): void
    {
        $this->cotizacion = $cotizacion->loadMissing(['destino','tipoViaje']);

        if ($planId = (int) $request->query('plan')) {
            $this->plan = Plan::with('aseguradora')->find($planId);
        }

        // ✅ Calcular precio y moneda para mostrar en el resumen
        $this->calcularPrecioResumen($quotes);

        $this->pasajerosData = [];
        $pasajeros = $this->cotizacion->pasajeros()->get();
        foreach ($pasajeros as $pasajero) {
            $this->pasajerosData[] = [
                'id' => $pasajero->id,
                'nombre' => $pasajero->nombre ?? '',
                'apellido' => $pasajero->apellido ?? '',
                'fecha_nacimiento' => $pasajero->fecha_nacimiento ?? '',
                'tipo_documento' => $pasajero->tipo_documento ?? '',
                'numero_documento' => $pasajero->numero_documento ?? '',
                'direccion' => $pasajero->direccion ?? '',
                'pais' => $pasajero->pais ?? '',
                'contacto_emergencia_nombre' => $pasajero->contacto_emergencia_nombre ?? '',
                'contacto_emergencia_telefono' => $pasajero->contacto_emergencia_telefono ?? '',
                'contacto_emergencia_email' => $pasajero->contacto_emergencia_email ?? '',
            ];
        }
    }

    /**
     * ✅ Nuevo método para calcular precio del resumen
     */
    private function calcularPrecioResumen(QuoteService $quotes): void
    {
        $this->monedaMostrada = $quotes->monedaParaPais($this->cotizacion->pais_origen);
        $this->tasaUsdCop = $quotes->obtenerTasaUsdCop();

        if (!$this->plan) {
            // Si no hay plan seleccionado, no mostrar precio
            $this->precioMostrado = null;
            return;
        }

        // Obtener el plan con precio calculado usando QuoteService
        $planesCalculados = $quotes->planesParaCotizacion($this->cotizacion);
        $planConPrecio = $planesCalculados->where('id', $this->plan->id)->first();

        if ($planConPrecio && isset($planConPrecio->precio_final)) {
            $this->precioMostrado = (float) $planConPrecio->precio_final;
        } else {
            $this->precioMostrado = null;
        }
    }

    public function saveCheckout(QuoteService $quotes)
    {
        $this->validate([
            'pasajerosData.*.nombre' => 'required|string|max:255',
            'pasajerosData.*.apellido' => 'required|string|max:255',
            'pasajerosData.*.fecha_nacimiento' => 'nullable|date',
        ]);

        // Guardar datos de pasajeros
        $allowed = [
            'nombre','apellido','fecha_nacimiento','tipo_documento','numero_documento',
            'direccion','pais','contacto_emergencia_nombre','contacto_emergencia_telefono','contacto_emergencia_email',
        ];
        foreach ($this->pasajerosData as $data) {
            $pasajero = $this->cotizacion->pasajeros()->find($data['id']);
            if ($pasajero) {
                $pasajero->update(Arr::only($data, $allowed));
            }
        }
        $this->cotizacion->refresh()->loadMissing(['destino','tipoViaje']);

        if ($this->cotizacion->correo_contacto) {
            Mail::to($this->cotizacion->correo_contacto)->send(new ConfirmacionCompraMail($this->cotizacion));
        }

        // Calcular plan/precio/moneda
        $moneda = $quotes->monedaParaPais($this->cotizacion->pais_origen);
        $precio = null;
        $aseguradoraId = null;

        $plan = $this->plan;
        if (!$plan) {
            $cand = $quotes->planesParaCotizacion($this->cotizacion)->first();
            $plan = $cand;
        }
        if ($plan) {
            $aseguradoraId = $plan->aseguradora_id ?? null;
            $cand = $quotes->planesParaCotizacion($this->cotizacion)->where('id', $plan->id)->first();
            if ($cand) { $precio = (float) $cand->precio_final; }
        }

        // Teléfono del admin: AppSetting primero, fallback a config/services.php
        $adminPhone = AppSetting::adminWhatsapp() ?: (string) Config::get('services.admin_whatsapp', '');
        $phone = preg_replace('/\D+/', '', $adminPhone);

        // Datos para la orden
        $primerPasajero = $this->cotizacion->pasajeros()->first();
        $cliente = trim(($primerPasajero->nombre ?? '') . ' ' . ($primerPasajero->apellido ?? '')) ?: ($this->cotizacion->correo_contacto ?? 'Cliente');

        $destino   = $this->cotizacion->destino->nombre   ?? ('Destino #' . $this->cotizacion->destino_id);
        $tipoViaje = $this->cotizacion->tipoViaje->nombre ?? ('Tipo #' . $this->cotizacion->tipo_viaje_id);
        $fechas    = $this->cotizacion->fecha_salida . ' → ' . $this->cotizacion->fecha_regreso;
        $countPas  = $this->cotizacion->pasajeros()->count();

        $dec     = $moneda === 'USD' ? 2 : 0;
        $simbolo = $moneda === 'USD' ? 'US$' : '$';
        $precioTxt = $precio !== null ? ($simbolo . number_format($precio, $dec)) : 'N/D';
        $planNombre  = $plan?->nombre ?? 'Plan no especificado';
        $aseguradora = $plan?->aseguradora?->nombre ?? '';

        $mensaje = "Hola, soy {$cliente}. Quiero confirmar la compra del paquete:\n"
            . "• Cotización #{$this->cotizacion->id}\n"
            . "• Plan: {$planNombre}" . ($aseguradora ? " ({$aseguradora})" : "") . "\n"
            . "• Destino: {$destino}\n"
            . "• Tipo de viaje: {$tipoViaje}\n"
            . "• Fechas: {$fechas}\n"
            . "• Pasajeros: {$countPas}\n"
            . "• Precio: {$precioTxt}\n"
            . "Datos de contacto: {$this->cotizacion->correo_contacto}"
            . ($this->cotizacion->telefono_contacto ? " / {$this->cotizacion->telefono_contacto}" : "");

        // Crear la orden (registro)
        $order = Order::create([
            'cotizacion_id'   => $this->cotizacion->id,
            'plan_id'         => $plan?->id,
            'aseguradora_id'  => $aseguradoraId,
            'estado'          => 'creada',
            'moneda'          => $moneda,
            'precio'          => $precio,
            'tasa_usd_cop'    => AppSetting::usdCop(),
            'admin_whatsapp'  => $phone ?: null,
            'cliente_nombre'  => $cliente,
            'cliente_email'   => $this->cotizacion->correo_contacto,
            'cliente_telefono'=> $this->cotizacion->telefono_contacto,
            'destino'         => $destino,
            'tipo_viaje'      => $tipoViaje,
            'fecha_salida'    => $this->cotizacion->fecha_salida,
            'fecha_regreso'   => $this->cotizacion->fecha_regreso,
            'pasajeros_count' => $countPas,
            'pasajeros_payload' => $this->pasajerosData, // snapshot del form
            'whatsapp_message'=> $mensaje,
            'sent_to_whatsapp_at' => now(), // marcamos el intento de envío
        ]);

        // Redirección a WhatsApp (si está configurado)
        if ($phone) {
            $url = "https://wa.me/{$phone}?text=" . urlencode($mensaje);
            session()->flash('success_message', "¡Compra confirmada! Te llevamos a WhatsApp (#Orden {$order->id}).");
            return redirect()->away($url);
        }

        // Si no hay teléfono configurado, ir a /gracias
        session()->flash('success_message', "¡Compra confirmada! Orden #{$order->id}. (Configura el WhatsApp del admin para redirigir automáticamente).");
        return redirect()->to('/gracias');
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}