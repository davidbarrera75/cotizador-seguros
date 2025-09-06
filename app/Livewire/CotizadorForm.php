<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Destino;
use App\Models\TipoViaje;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;

class CotizadorForm extends Component
{
    // --- Campos del formulario ---
    public string $pais_origen = 'CO';  // ISO-2 por defecto (Colombia)
    public $destino_id = '';
    public $tipo_viaje_id = '';
    public ?string $fecha_salida = null;
    public ?string $fecha_regreso = null;
    public ?string $correo_contacto = null;
    public ?string $telefono_contacto = null;

    /** Uno o más pasajeros, cada uno con 'edad' */
    public array $pasajeros = [['edad' => '']];

    // --- Validación ---
    protected function rules(): array
    {
        return [
            'pais_origen'      => 'required|string|size:2',      // usamos ISO-2 (CO, AR, US, etc.)
            'destino_id'       => 'required|exists:destinos,id',
            'tipo_viaje_id'    => 'required|exists:tipo_viajes,id',
            'fecha_salida'     => 'required|date|after_or_equal:today',
            'fecha_regreso'    => 'required|date|after:fecha_salida',
            'correo_contacto'  => 'required|email',
            'telefono_contacto'=> 'nullable|string',
            'pasajeros.*.edad' => 'required|integer|min:0|max:120',
        ];
    }

    protected array $messages = [
        'pais_origen.required'   => 'Debes seleccionar un país de origen.',
        'destino_id.required'    => 'Debes seleccionar un destino.',
        'tipo_viaje_id.required' => 'Debes seleccionar un tipo de viaje.',
        'fecha_salida.required'  => 'La fecha de salida es obligatoria.',
        'fecha_regreso.required' => 'La fecha de regreso es obligatoria.',
        'fecha_regreso.after'    => 'La fecha de regreso debe ser posterior a la de salida.',
        'correo_contacto.required' => 'El correo es obligatorio.',
        'correo_contacto.email'  => 'Ingresa un correo válido.',
        'pasajeros.*.edad.required' => 'La edad del pasajero es obligatoria.',
    ];

    // --- Helpers para países ---
    /** Lista de países (ISO-2 => nombre). Visible como $this->paisesOrigen en Blade. */
    public function getPaisesOrigenProperty(): array
    {
        return [
            // LatAm + algunos frecuentes (puedes ampliar cuando quieras)
            'CO'=>'Colombia','AR'=>'Argentina','BO'=>'Bolivia','BR'=>'Brasil','CL'=>'Chile','EC'=>'Ecuador',
            'PY'=>'Paraguay','PE'=>'Perú','UY'=>'Uruguay','VE'=>'Venezuela','MX'=>'México','CR'=>'Costa Rica',
            'PA'=>'Panamá','GT'=>'Guatemala','SV'=>'El Salvador','HN'=>'Honduras','NI'=>'Nicaragua',
            // Norteamérica / Europa comunes
            'US'=>'Estados Unidos','CA'=>'Canadá','ES'=>'España','FR'=>'Francia','IT'=>'Italia','DE'=>'Alemania',
            'GB'=>'Reino Unido','PT'=>'Portugal','NL'=>'Países Bajos','BE'=>'Bélgica','CH'=>'Suiza',
        ];
    }

    /** Nombre del país a partir del ISO-2 (por si lo necesitas en la vista) */
    public function getPaisNombre(): string
    {
        return $this->paisesOrigen[$this->pais_origen] ?? 'Colombia';
    }

    // --- Gestión de pasajeros ---
    public function agregarPasajero(): void
    {
        $this->pasajeros[] = ['edad' => ''];
    }

    public function removerPasajero(int $index): void
    {
        if (count($this->pasajeros) > 1) {
            unset($this->pasajeros[$index]);
            $this->pasajeros = array_values($this->pasajeros);
        }
    }

    // --- Guardar cotización ---
    public function guardarCotizacion()
    {
        $this->validate();

        $cotizacion = null;

        DB::transaction(function () use (&$cotizacion) {
            // 1) Crear la cotización (guardamos ISO-2 en 'pais_origen')
            $cotizacion = Cotizacion::create([
    'destino_id'        => $this->destino_id,
    'tipo_viaje_id'     => $this->tipo_viaje_id,
    'pais_origen'       => $this->pais_origen,        // ISO-2 (p.ej. CL)
    'origen'            => $this->getPaisNombre(),    // ← nombre (p.ej. Chile) PARA CALMAR LA BD
    'fecha_salida'      => $this->fecha_salida,
    'fecha_regreso'     => $this->fecha_regreso,
    'correo_contacto'   => $this->correo_contacto,
    'telefono_contacto' => $this->telefono_contacto,
]);


            // 2) Crear pasajeros
            foreach ($this->pasajeros as $pasajero) {
                $cotizacion->pasajeros()->create([
                    'edad' => (int) $pasajero['edad'],
                ]);
            }
        });

        session()->flash('message', 'Cotización enviada exitosamente.');
         return redirect()->route('resultados', ['cotizacion' => $cotizacion->id]);

        // Redirigimos fuera de la transacción (más limpio para Livewire)
        return redirect()->route('resultados', ['cotizacion' => $cotizacion->id]);
    }

    public function render()
    {
        return view('livewire.cotizador-form', [
            'destinos'   => Destino::where('activo', true)->get(),
            'tiposViaje' => TipoViaje::where('activo', true)->get(),
            'paises'     => $this->paisesOrigen, // disponible para el <select>
        ]);
    }
}
