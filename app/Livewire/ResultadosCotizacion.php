<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Cotizacion;
use App\Services\Cotizador\QuoteService;

class ResultadosCotizacion extends Component
{
    /** La cotización recibida por Route Model Binding */
    public Cotizacion $cotizacion;

    /** Planes listos para mostrar en la vista (con precio_final ya convertido) */
    public array $planesEncontrados = [];

    /** Moneda calculada por país de origen: 'COP' si CO, de lo contrario 'USD' */
    public string $moneda = 'COP';

    /** Indicador de carga para la recotización */
    public bool $loadingPlanes = false;

    /**
     * Se ejecuta al cargar el componente.
     * Inyectamos QuoteService para centralizar la lógica de días, moneda y conversión.
     */
    public function mount(Cotizacion $cotizacion, QuoteService $quotes): void
    {
        // Cargar relación pasajeros por si la vista o el servicio la usan
        $this->cotizacion = $cotizacion->loadMissing('pasajeros');

        // Cargar planes iniciales
        $this->cargarPlanes($quotes);
    }

    /**
     * Escucha el evento 'planesActualizados' emitido por RecotizacionPanel
     */
    #[On('planesActualizados')]
    public function actualizarPlanes(): void
    {
        $this->loadingPlanes = true;
        
        // Recargar la cotización con los nuevos datos
        $this->cotizacion = $this->cotizacion->fresh(['pasajeros', 'destino', 'tipoViaje']);
        
        /** @var QuoteService $quotes */
        $quotes = app(QuoteService::class);
        
        $this->cargarPlanes($quotes);
        
        $this->loadingPlanes = false;
    }

    /**
     * Método privado para cargar planes usando QuoteService
     */
    private function cargarPlanes(QuoteService $quotes): void
    {
        // Moneda según país de origen (CO => COP; otro => USD)
        $this->moneda = $quotes->monedaParaPais($this->cotizacion->pais_origen);

        // Cargar planes usando el servicio (incluye selección de tarifa y conversión de moneda)
        $planes = $quotes->planesParaCotizacion($this->cotizacion);

        // Pasamos a array para la vista Livewire
        $this->planesEncontrados = $planes->values()->all();
    }

    /**
     * (Opcional) Recargar planes manualmente.
     * Usa el contenedor para resolver el servicio sin necesidad de inyección en la firma.
     */
    public function buscarPlanes(): void
    {
        /** @var QuoteService $quotes */
        $quotes = app(QuoteService::class);

        $this->cargarPlanes($quotes);
    }

    public function render()
    {
        return view('livewire.resultados-cotizacion');
    }
}