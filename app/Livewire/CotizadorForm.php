<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Destino;
use App\Models\Region;
use App\Models\Pais;
use App\Models\TipoViaje;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;
use App\Models\SliderImage;

class CotizadorForm extends Component
{
    // --- Campos del formulario ---
    public $region_id = '';
    public $destino_pais_id = '';      // País de destino
    public $origen_pais_id = '';       // País de origen
    public $tipo_viaje_id = '';
    public ?string $fecha_salida = null;
    public ?string $fecha_regreso = null;
    public ?string $correo_contacto = null;
    public ?string $telefono_contacto = null;

    /** Uno o más pasajeros, cada uno con 'edad' */
    public array $pasajeros = [['edad' => '']];

    /** Imágenes del slider */
    public array $sliderImages = [];

    public function mount()
    {
        // Valor por defecto para país de origen (Colombia)
        $paisColombia = Pais::where('codigo', 'CO')->first();
        if ($paisColombia) {
            $this->origen_pais_id = $paisColombia->id;
        }

        $this->sliderImages = SliderImage::active()
            ->orderBy('sort')
            ->limit(4)
            ->get()
            ->map(fn($s) => [
                'url'   => $s->url,
                'title' => $s->title ?? '',
            ])->toArray();
    }

    // --- Validación ---
    protected function rules(): array
    {
        return [
            'region_id'        => 'required|exists:regions,id',
            'destino_pais_id'  => 'required|exists:pais,id',
            'origen_pais_id'   => 'required|exists:pais,id',
            'tipo_viaje_id'    => 'required|exists:tipo_viajes,id',
            'fecha_salida'     => 'required|date|after_or_equal:today',
            'fecha_regreso'    => 'required|date|after:fecha_salida',
            'correo_contacto'  => 'required|email',
            'telefono_contacto'=> 'nullable|string',
            'pasajeros.*.edad' => 'required|integer|min:0|max:120',
        ];
    }

    protected array $messages = [
        'region_id.required'      => 'Debes seleccionar una región.',
        'destino_pais_id.required'=> 'Debes seleccionar un país de destino.',
        'origen_pais_id.required' => 'Debes seleccionar un país de origen.',
        'tipo_viaje_id.required'  => 'Debes seleccionar un tipo de viaje.',
        'fecha_salida.required'   => 'La fecha de salida es obligatoria.',
        'fecha_regreso.required'  => 'La fecha de regreso es obligatoria.',
        'fecha_regreso.after'     => 'La fecha de regreso debe ser posterior a la de salida.',
        'correo_contacto.required'=> 'El correo es obligatorio.',
        'correo_contacto.email'   => 'Ingresa un correo válido.',
        'pasajeros.*.edad.required'=> 'La edad del pasajero es obligatoria.',
    ];

    // --- Gestión de pasajeros ---
    public function agregarPasajero(): void
    {
        $this->pasajeros[] = ['edad' => ''];
    }

    public function removerPasajero()
    {
        if (count($this->pasajeros) > 1) {
            array_pop($this->pasajeros);
        }
    }

    // --- Guardar cotización ---
    public function guardarCotizacion()
    {
        $this->validate();

        $cotizacion = null;

        DB::transaction(function () use (&$cotizacion) {
            // Obtener datos de país de origen para compatibilidad
            $paisOrigen = Pais::find($this->origen_pais_id);

            // Crear la cotización
            $cotizacion = Cotizacion::create([
                'region_id'          => $this->region_id,
                'destino_pais_id'    => $this->destino_pais_id,
                'origen_pais_id'     => $this->origen_pais_id,
                'tipo_viaje_id'      => $this->tipo_viaje_id,
                'pais_origen'        => $paisOrigen?->codigo ?? 'CO',
                'origen'             => $paisOrigen?->nombre ?? 'Colombia',
                'fecha_salida'       => $this->fecha_salida,
                'fecha_regreso'      => $this->fecha_regreso,
                'correo_contacto'    => $this->correo_contacto,
                'telefono_contacto'  => $this->telefono_contacto,
            ]);

            // Crear pasajeros
            foreach ($this->pasajeros as $pasajero) {
                $cotizacion->pasajeros()->create([
                    'edad' => (int) $pasajero['edad'],
                ]);
            }
        });

        session()->flash('message', 'Cotización enviada exitosamente.');
        return redirect()->route('resultados', ['cotizacion' => $cotizacion->id]);
    }

    public function render()
    {
        return view('livewire.cotizador-form', [
            'regiones'      => Region::where('activo', true)->get(),
            'paises'        => Pais::where('activo', true)->orderBy('nombre')->get(),
            'tiposViaje'    => TipoViaje::where('activo', true)->get(),
            'sliderImages'  => $this->sliderImages,
        ]);
    }
}
