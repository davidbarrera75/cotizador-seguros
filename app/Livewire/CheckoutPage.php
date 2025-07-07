<?php

namespace App\Livewire;

use App\Models\Cotizacion;
use App\Mail\ConfirmacionCompraMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckoutPage extends Component
{
    public Cotizacion $cotizacion;
    public $pasajerosData = [];

    public $tiposDeDocumento = [
        'Cédula de ciudadanía',
        'Cédula de extranjería',
        'Pasaporte',
        'Tarjeta de identidad',
    ];

    public $paises = [
        'Colombia',
        'Argentina',
        'Brasil',
        'Chile',
        'Ecuador',
        'España',
        'Estados Unidos',
        'México',
        'Perú'
    ];

    public function mount(Cotizacion $cotizacion)
    {
        $this->cotizacion = $cotizacion;

        foreach ($this->cotizacion->pasajeros as $pasajero) {
            $this->pasajerosData[] = [
                'id' => $pasajero->id,
                'nombre' => '',
                'apellido' => '',
                'fecha_nacimiento' => '',
                'tipo_documento' => '',
                'numero_documento' => '',
                'direccion' => '',
                'pais' => '',
                'contacto_emergencia_nombre' => '',
                'contacto_emergencia_telefono' => '',
                'contacto_emergencia_email' => '',
            ];
        }
    }

    public function saveCheckout()
    {
        $this->validate([
            'pasajerosData.*.nombre' => 'required|string|max:255',
            'pasajerosData.*.apellido' => 'required|string|max:255',
            'pasajerosData.*.fecha_nacimiento' => 'required|date',
        ]);

        foreach ($this->pasajerosData as $data) {
            $pasajero = $this->cotizacion->pasajeros()->find($data['id']);
            if ($pasajero) {
                $pasajero->update($data);
            }
        }

        $this->cotizacion->refresh();

        Mail::to($this->cotizacion->correo_contacto)

            ->send(new ConfirmacionCompraMail($this->cotizacion));

        session()->flash('success_message', '¡Compra confirmada! Hemos enviado un resumen a tu correo.');

        return redirect()->to('/gracias');
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
