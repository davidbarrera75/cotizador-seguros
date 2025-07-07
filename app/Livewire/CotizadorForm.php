<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Destino;
use App\Models\TipoViaje;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB; // Importante para usar transacciones

class CotizadorForm extends Component
{
    // Propiedades para los campos del formulario
    public $destino_id = '';
    public $tipo_viaje_id = '';
    public $fecha_salida;
    public $fecha_regreso;
    public $correo_contacto;
    public $telefono_contacto;
    public $pasajeros = [];

    // Reglas de validación (de tu propuesta)
    protected $rules = [
        'destino_id' => 'required|exists:destinos,id',
        'tipo_viaje_id' => 'required|exists:tipo_viajes,id',
        'fecha_salida' => 'required|date|after_or_equal:today',
        'fecha_regreso' => 'required|date|after:fecha_salida',
        'correo_contacto' => 'required|email',
        'telefono_contacto' => 'nullable|string',
        'pasajeros.*.edad' => 'required|integer|min:0|max:120'
    ];

    // Mensajes de error personalizados (de tu propuesta)
    protected $messages = [
        'destino_id.required' => 'Debes seleccionar un destino.',
        'tipo_viaje_id.required' => 'Debes seleccionar un tipo de viaje.',
        'fecha_salida.required' => 'La fecha de salida es obligatoria.',
        'fecha_regreso.required' => 'La fecha de regreso es obligatoria.',
        'fecha_regreso.after' => 'La fecha de regreso debe ser posterior a la de salida.',
        'correo_contacto.required' => 'El correo es obligatorio.',
        'correo_contacto.email' => 'Ingresa un formato de correo válido.',
        'pasajeros.*.edad.required' => 'La edad del pasajero es obligatoria.',
    ];

    // Se ejecuta cuando el componente se carga por primera vez
    public function mount()
    {
        $this->pasajeros = [['edad' => '']]; // Empezamos con un pasajero
    }

    // Funciones para manejar pasajeros (de tu propuesta)
    public function agregarPasajero()
    {
        $this->pasajeros[] = ['edad' => ''];
    }

    public function removerPasajero($index)
    {
        if (count($this->pasajeros) > 1) {
            unset($this->pasajeros[$index]);
            $this->pasajeros = array_values($this->pasajeros);
        }
    }

    // Se ejecuta al enviar el formulario (nuestra versión combinada)
    public function guardarCotizacion()
    {
        $this->validate(); // Usa las reglas definidas en $rules

        try {
            DB::transaction(function () {
                // 1. Crear la cotización principal
                $cotizacion = Cotizacion::create([
                    'destino_id' => $this->destino_id,
                    'tipo_viaje_id' => $this->tipo_viaje_id,
                    'origen' => 'Colombia', // Origen fijo por ahora
                    'fecha_salida' => $this->fecha_salida,
                    'fecha_regreso' => $this->fecha_regreso,
                    'correo_contacto' => $this->correo_contacto,
                    'telefono_contacto' => $this->telefono_contacto,
                ]);

                // 2. Crear un registro en la tabla 'pasajeros' por cada pasajero
                foreach ($this->pasajeros as $pasajero) {
                    $cotizacion->pasajeros()->create([
                        'edad' => $pasajero['edad'],
                    ]);
                }

                // Redirigir a la página de resultados
                // (Usaremos un flash message antes de redirigir)
                session()->flash('message', 'Cotización enviada exitosamente. Redirigiendo a resultados...');

                // NOTA: La redirección real la haremos en el siguiente paso
                return redirect()->to('/resultados/' . $cotizacion->id);
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar la cotización. Intenta nuevamente.');
        }
    }

    // Renderiza la vista y le pasa los datos necesarios
    public function render()
    {
        return view('livewire.cotizador-form', [
            'destinos' => Destino::where('activo', true)->get(),
            'tiposViaje' => TipoViaje::where('activo', true)->get(),
        ]);
    }
}
