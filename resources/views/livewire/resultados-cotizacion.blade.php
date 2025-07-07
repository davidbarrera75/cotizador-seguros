<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Planes Encontrados</h1>

    <div class="space-y-6">
        @forelse($planesEncontrados as $plan)
        <div class="p-6 bg-white rounded-lg shadow-md flex justify-between items-center">
            <div>
                @if($plan->aseguradora->logo)
                <img src="{{ Storage::url($plan->aseguradora->logo) }}" alt="{{ $plan->aseguradora->nombre }}" class="h-10 mb-2">
                @endif
                <h2 class="text-xl font-bold text-gray-900">{{ $plan->nombre }}</h2>
                <p class="text-sm text-gray-600">{{ $plan->aseguradora->nombre }}</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">${{ number_format($plan->precio_final, 2) }}</p>
                <a href="/checkout/{{ $cotizacion->id }}" class="mt-2 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                    Comprar Ahora
                </a>
            </div>
        </div>
        @empty
        <div class="p-6 bg-white rounded-lg shadow-md text-center">
            <p class="text-lg text-gray-700">No se encontraron planes que coincidan con tu búsqueda.</p>
        </div>
        @endforelse
    </div>
</div>