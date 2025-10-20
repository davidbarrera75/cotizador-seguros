<?php

namespace App\Livewire;

use App\Models\Cotizacion;
use App\Models\Destino;
use App\Models\TipoViaje;
use App\Services\Cotizador\QuoteService;
use Livewire\Component;
use Carbon\Carbon;

class RecotizacionPanel extends Component
{
    public Cotizacion $cotizacion;
    
    // Formulario de recotización
    public $fecha_salida;
    public $fecha_regreso;
    public $destino_id;
    public $tipo_viaje_id;
    public array $pasajeros = [];
    
    // Estados del componente
    public bool $loading = false;
    public bool $showAdvanced = false;
    
    // Datos originales para detectar cambios
    public array $originalData = [];

    protected $rules = [
        'fecha_salida' => 'required|date',
        'fecha_regreso' => 'required|date|after:fecha_salida',
        'destino_id' => 'required|exists:destinos,id',
        'tipo_viaje_id' => 'required|exists:tipo_viajes,id',
        'pasajeros.*.edad' => 'required|integer|min:0|max:100',
    ];

    public function mount(Cotizacion $cotizacion): void
    {
        $this->cotizacion = $cotizacion->loadMissing(['pasajeros', 'destino', 'tipoViaje']);
        
        // Inicializar formulario con datos actuales
        $this->fecha_salida = $cotizacion->fecha_salida;
        $this->fecha_regreso = $cotizacion->fecha_regreso;
        $this->destino_id = $cotizacion->destino_id;
        $this->tipo_viaje_id = $cotizacion->tipo_viaje_id;
        
        // ✅ CORRECCIÓN: Usar get() para asegurar que siempre devuelva una colección
        $pasajeros = $this->cotizacion->pasajeros()->get();
        
        if ($pasajeros->count() > 0) {
            $this->pasajeros = $pasajeros->map(function ($pasajero) {
                return ['edad' => $pasajero->edad ?? 30];
            })->toArray();
        } else {
            // Si no hay pasajeros, crear uno por defecto
            $this->pasajeros = [['edad' => 30]];
        }
        
        // Guardar datos originales
        $this->originalData = [
            'fecha_salida' => $this->fecha_salida,
            'fecha_regreso' => $this->fecha_regreso,
            'destino_id' => $this->destino_id,
            'tipo_viaje_id' => $this->tipo_viaje_id,
            'pasajeros' => $this->pasajeros,
        ];
    }

    public function getCalculatedDaysProperty(): int
    {
        if (!$this->fecha_salida || !$this->fecha_regreso) {
            return 1;
        }
        
        try {
            $start = Carbon::parse($this->fecha_salida);
            $end = Carbon::parse($this->fecha_regreso);
            return max(1, $start->diffInDays($end) + 1);
        } catch (\Exception $e) {
            return 1;
        }
    }

    public function getHasChangesProperty(): bool
    {
        $currentData = [
            'fecha_salida' => $this->fecha_salida,
            'fecha_regreso' => $this->fecha_regreso,
            'destino_id' => $this->destino_id,
            'tipo_viaje_id' => $this->tipo_viaje_id,
            'pasajeros' => $this->pasajeros,
        ];
        
        return $currentData !== $this->originalData;
    }

    public function addPasajero(): void
    {
        if (count($this->pasajeros) < 10) {
            $this->pasajeros[] = ['edad' => 30];
        }
    }

    public function removePasajero(): void
    {
        if (count($this->pasajeros) > 1) {
            array_pop($this->pasajeros);
        }
    }

    public function removePasajeroIndex(int $index): void
    {
        if (count($this->pasajeros) > 1 && isset($this->pasajeros[$index])) {
            unset($this->pasajeros[$index]);
            $this->pasajeros = array_values($this->pasajeros); // Reindexar
        }
    }

    public function recotizar(QuoteService $quotes): void
    {
        $this->loading = true;
        
        try {
            $this->validate();
            
            // Actualizar la cotización con los nuevos datos
            $this->cotizacion->update([
                'fecha_salida' => $this->fecha_salida,
                'fecha_regreso' => $this->fecha_regreso,
                'destino_id' => $this->destino_id,
                'tipo_viaje_id' => $this->tipo_viaje_id,
            ]);
            
            // Actualizar pasajeros
            $this->cotizacion->pasajeros()->delete();
            foreach ($this->pasajeros as $index => $pasajeroData) {
                $this->cotizacion->pasajeros()->create([
                    'nombre' => "Pasajero " . ($index + 1),
                    'edad' => $pasajeroData['edad'],
                ]);
            }
            
            // Limpiar cache del QuoteService para esta cotización
            $quotes->bustCacheForCotizacion($this->cotizacion);
            
            // Emitir evento para que ResultadosCotizacion recargue los planes
            $this->dispatch('planesActualizados');
            
            // Actualizar datos originales
            $this->originalData = [
                'fecha_salida' => $this->fecha_salida,
                'fecha_regreso' => $this->fecha_regreso,
                'destino_id' => $this->destino_id,
                'tipo_viaje_id' => $this->tipo_viaje_id,
                'pasajeros' => $this->pasajeros,
            ];
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Los errores de validación se muestran automáticamente
        } catch (\Exception $e) {
            session()->flash('error', 'Error al recotizar: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        $destinos = Destino::orderBy('nombre')->get();
        $tiposViaje = TipoViaje::orderBy('nombre')->get();
        
        return view('livewire.recotizacion-panel', compact('destinos', 'tiposViaje'));
    }
}