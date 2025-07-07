<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\Plan;
use Carbon\Carbon;

class ResultadosCotizacion extends Component
{
    public Cotizacion $cotizacion;
    public $planesEncontrados = [];

    // Se ejecuta al cargar el componente, recibe la cotización desde la URL
    public function mount(Cotizacion $cotizacion)
    {
        $this->cotizacion = $cotizacion;
        $this->buscarPlanes();
    }

    public function buscarPlanes()
    {
        // Calcular datos clave de la cotización
        $fechaSalida = Carbon::parse($this->cotizacion->fecha_salida);
        $fechaRegreso = Carbon::parse($this->cotizacion->fecha_regreso);
        $diasDeViaje = $fechaRegreso->diffInDays($fechaSalida) + 1;
        $edadMaximaPasajero = $this->cotizacion->pasajeros->max('edad');

        // Buscar planes que coincidan
        $planes = Plan::where('activo', true)
            ->where('edad_maxima', '>=', $edadMaximaPasajero)
            ->whereHas('destinos', function ($query) {
                $query->where('destino_id', $this->cotizacion->destino_id);
            })
            ->whereHas('tiposViaje', function ($query) {
                $query->where('tipo_viaje_id', $this->cotizacion->tipo_viaje_id);
            })
            ->with(['aseguradora', 'tarifas' => function ($query) use ($diasDeViaje) {
                $query->where('dias', '>=', $diasDeViaje)->orderBy('dias', 'asc');
            }])
            ->get();

        // Filtrar y asignar precio final
        foreach ($planes as $plan) {
            $tarifaAplicable = $plan->tarifas->first();
            if ($tarifaAplicable) {
                $plan->precio_final = $tarifaAplicable->precio;
                $this->planesEncontrados[] = $plan;
            }
        }
    }

    public function render()
    {
        return view('livewire.resultados-cotizacion');
    }
}
