<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Planes Encontrados</h1>

    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <!-- Panel izquierdo: Recotización -->
        <aside class="lg:col-span-4 mb-6 lg:mb-0">
            @livewire('recotizacion-panel', ['cotizacion' => $cotizacion])
        </aside>

        <!-- Contenido derecho: Lista de Planes -->
        <main class="lg:col-span-8">
            @php
                // helpers locales
                $fmt = function ($m, $v) {
                    $dec = $m === 'USD' ? 2 : 0;
                    $sym = $m === 'USD' ? 'US$' : '$';
                    return $sym . number_format((float)$v, $dec);
                };
            @endphp

            <!-- Indicador de carga -->
            @if($loadingPlanes)
                <div class="flex items-center justify-center py-12">
                    <div class="flex items-center gap-3 text-gray-600">
                        <svg class="animate-spin w-6 h-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Actualizando planes...</span>
                    </div>
                </div>
            @else
                <div class="space-y-5">
                    @forelse($planesEncontrados as $i => $plan)
                        @php
                            $moneda         = $plan->moneda ?? 'COP';
                            $precioFinal    = $plan->precio_final ?? null;
                            $precioBase     = $plan->precio_sin_desc ?? null;
                            $descuento      = (float)($plan->descuento_aplicado ?? 0);
                            $diasTarifa     = $plan->dias_tarifa ?? null;
                            $logo           = $plan->aseguradora->logo ?? null;
                            $rating         = $plan->rating ?? null; // opcional en DB
                            $coberturaPdf   = $plan->cobertura_pdf_path ?? null; // opcional en DB
                            $coberturaText  = $plan->cobertura ?? null; // opcional en DB
                            $diasCotizados  = $plan->dias_cotizados ?? null;
                            $numeroPax      = $plan->numero_pasajeros ?? 1;
                        @endphp

                        <div x-data="{ openCov{{ $i }}: false }" class="p-6 bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                {{-- Izquierda: logo + nombre + aseguradora + rating + info --}}
                                <div class="flex items-center gap-6 min-w-0">
                                    @if($logo)
                                        <img src="{{ Storage::url($logo) }}" alt="{{ $plan->aseguradora->nombre ?? 'Aseguradora' }}"
                                             class="h-12 w-auto object-contain">
                                    @endif

                                    <div class="min-w-0">
                                        <h2 class="text-2xl font-bold text-gray-900 truncate">
                                            {{ $plan->nombre }}
                                        </h2>
                                        <p class="text-sm text-gray-600">
                                            {{ $plan->aseguradora->nombre ?? '' }}
                                        </p>

                                        {{-- ⭐️ Rating con medias estrellas --}}
                                        @if(!is_null($rating))
                                            @php
                                                // rating entre 0 y 5 (acepta decimales, ej. 4.5)
                                                $r = max(0, min(5, (float)$rating));
                                            @endphp

                                            <div class="mt-1 flex items-center gap-1">
                                                @for ($star = 1; $star <= 5; $star++)
                                                    @php
                                                        $diff = $r - ($star - 1); // cuánto "llena" esta estrella
                                                    @endphp
                                                    <span class="inline-block relative h-5 w-5">
                                                        {{-- base: estrella vacía (gris) --}}
                                                        <svg class="absolute inset-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L6.185 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.55 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>

                                                        @if ($diff >= 1)
                                                            {{-- estrella llena (amarilla) --}}
                                                            <svg class="absolute inset-0 text-yellow-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L6.185 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.55 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @elseif ($diff >= 0.5)
                                                            {{-- media estrella: recortamos una estrella llena al 50% --}}
                                                            <span class="absolute inset-0 overflow-hidden" style="width:50%">
                                                                <svg class="absolute inset-0 text-yellow-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L6.185 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.55 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </span>
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-600">{{ number_format($r, 1) }}/5</span>
                                            </div>
                                        @endif

                                        <div class="text-sm text-gray-500 mt-1 space-y-1">
                                            @if($diasCotizados)
                                                <p>
                                                    <span class="font-medium">{{ $diasCotizados }}</span> 
                                                    {{ $diasCotizados == 1 ? 'día' : 'días' }} de viaje
                                                    @if($numeroPax > 1)
                                                        × {{ $numeroPax }} {{ $numeroPax == 1 ? 'persona' : 'personas' }}
                                                    @endif
                                                </p>
                                            @endif
                                            @if($diasTarifa && $diasTarifa != $diasCotizados)
                                                <p class="text-xs text-gray-400">
                                                    (Cobertura hasta {{ $diasTarifa }} días)
                                                </p>
                                            @endif
                                        </div>

                                        {{-- Botón Cobertura --}}
                                        <button type="button"
                                                class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 mt-2"
                                                @click="openCov{{ $i }} = true">
                                            Cobertura
                                        </button>
                                    </div>
                                </div>

                                {{-- Derecha: precios y botón comprar --}}
                                <div class="flex flex-col items-end gap-2 shrink-0">
                                    {{-- precio tachado + badge si hay descuento --}}
                                    @if($descuento > 0 && !is_null($precioBase))
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-400 line-through">
                                                {{ $fmt($moneda, $precioBase) }}
                                            </span>
                                            <span class="inline-block text-xs font-semibold bg-orange-100 text-orange-700 px-2 py-0.5 rounded">
                                                {{ number_format($descuento, 0) }}% OFF
                                            </span>
                                        </div>
                                    @endif

                                    {{-- precio final --}}
                                    <div class="text-2xl md:text-3xl font-extrabold text-blue-600">
                                        {{ $fmt($moneda, $precioFinal) }}
                                    </div>

                                    <a href="/checkout/{{ $cotizacion->id }}?plan={{ $plan->id }}"
                                       class="mt-2 inline-flex items-center justify-center px-5 py-2 rounded-md bg-green-500 hover:bg-green-600 text-white font-semibold">
                                        Comprar Ahora
                                    </a>
                                </div>
                            </div>

                            {{-- Modal Cobertura --}}
                            <div x-cloak x-show="openCov{{ $i }}" x-transition
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                                <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl overflow-hidden">
                                    <div class="px-5 py-3 border-b flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">Cobertura — {{ $plan->nombre }}</h3>
                                        <button class="text-gray-500 hover:text-gray-700" @click="openCov{{ $i }} = false">✕</button>
                                    </div>
                                    <div class="p-4">
                                        @if($coberturaPdf)
                                            <iframe src="{{ Storage::url($coberturaPdf) }}" class="w-full h-[60vh]" frameborder="0"></iframe>
                                        @elseif($coberturaText)
                                            <div class="prose max-w-none">
                                                {!! nl2br(e($coberturaText)) !!}
                                            </div>
                                        @else
                                            <p class="text-gray-600">No hay información de cobertura disponible para este plan.</p>
                                        @endif
                                    </div>
                                    <div class="px-5 py-3 border-t text-right">
                                        <button class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200"
                                                @click="openCov{{ $i }} = false">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 bg-white rounded-xl shadow-sm border text-center text-gray-700">
                            No se encontraron planes que coincidan con tu búsqueda.
                        </div>
                    @endforelse
                </div>
            @endif
        </main>
    </div>
</div>