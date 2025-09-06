<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Planes Encontrados</h1>

    @php
        // Asegura iterable para evitar "foreach on null"
        $lista = ($planesEncontrados ?? []);
        // Si viene como objeto Collection también funciona; con [] evitamos null.
    @endphp

    <div class="space-y-6">
        @forelse($lista as $plan)
            @php
                // Moneda prioriza la que venga en el plan (calculada en el servicio)
                $m = $plan->moneda ?? ($moneda ?? 'COP');
                $dec = $m === 'USD' ? 2 : 0;
                $sym = $m === 'USD' ? 'US$' : '$';
                $precio = isset($plan->precio_final) ? number_format((float)$plan->precio_final, $dec) : 'N/D';

                $logo = $plan->aseguradora->logo ?? null;
                $aseg = $plan->aseguradora->nombre ?? '';
            @endphp

            <div class="p-6 bg-white rounded-lg shadow-md flex justify-between items-center">
                <div class="flex items-start gap-4">
                    @if($logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}"
                             alt="{{ $aseg }}" class="h-10 mt-1">
                    @endif
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $plan->nombre }}
                        </h2>
                        @if($aseg)
                            <p class="text-sm text-gray-600">{{ $aseg }}</p>
                        @endif
                        @if(!empty($plan->dias_tarifa))
                            <p class="text-xs text-gray-500 mt-1">
                                Tarifa aplicada: {{ $plan->dias_tarifa }} día(s)
                            </p>
                        @endif
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $sym }}{{ $precio }}
                    </p>

                    @if (Route::has('checkout'))
                        <a href="{{ route('checkout', ['cotizacion' => $cotizacion->id, 'plan' => $plan->id]) }}"
                           class="mt-2 inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                            Comprar Ahora
                        </a>
                    @else
                        <a href="/checkout/{{ $cotizacion->id }}?plan={{ $plan->id }}"
                           class="mt-2 inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                            Comprar Ahora
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-6 bg-white rounded-lg shadow-md text-center">
                <p class="text-lg text-gray-700">
                    No se encontraron planes que coincidan con tu búsqueda.
                </p>
            </div>
        @endforelse
    </div>
</div>
