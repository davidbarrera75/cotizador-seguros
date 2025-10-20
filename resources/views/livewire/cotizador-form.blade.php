{{-- Raíz única para Livewire --}}
<div
    x-data="{
        currentSlide: 0,
        images: @js($sliderImages),
        init() {
            if (this.images.length === 0) return;
            setInterval(() => {
                this.currentSlide = (this.currentSlide + 1) % this.images.length;
            }, 5000);
        }
    }"
    class="min-h-screen relative"
>

    {{-- Fondo a pantalla completa (slider dinámico) --}}
    <div class="absolute inset-0">
        <template x-for="(image, index) in images" :key="index">
            <div
                x-show="currentSlide === index"
                x-transition:enter="transition-opacity duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-cover bg-center"
                :style="`background-image: url('${image.url}')`"
            >
                <div class="absolute inset-0 bg-black/35"></div>

                {{-- Título opcional desde BD --}}
                <div class="absolute bottom-10 left-10 text-white z-20">
                    <h2 x-text="image.title" class="text-2xl font-bold drop-shadow"></h2>
                </div>
            </div>
        </template>

        {{-- Puntos del slider --}}
        <div class="absolute bottom-6 left-6 flex gap-2 z-10">
            <template x-for="(image, index) in images" :key="index">
                <button
                    @click="currentSlide = index"
                    class="w-3 h-3 rounded-full transition-all"
                    :class="currentSlide === index ? 'bg-white' : 'bg-white/50'">
                </button>
            </template>
        </div>
    </div>

    {{-- Contenido (card flotante) --}}
    <div class="relative z-10 flex items-center justify-end min-h-screen px-4 md:px-8">
        <div class="w-full max-w-lg">

            {{-- Card flotante (más compacta) --}}
            <div class="rounded-2xl border border-white/30 bg-white/90 backdrop-blur-xl shadow-2xl">
                {{-- Encabezado --}}
                <div class="px-6 pt-6 text-center">
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Compra fácil, <span class="text-orange-600">rápido</span> y seguro
                    </h2>
                    <p class="text-sm text-gray-600">Obtén tu cotización en segundos</p>
                </div>

                {{-- Mensajes --}}
                <div class="px-6 mt-4">
                    @if (session('message'))
                        <div class="mb-3 rounded-lg bg-emerald-50 text-emerald-700 p-3 text-sm text-center">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div wire:loading class="mb-3 rounded-lg border border-gray-200 bg-white/90 p-3 text-gray-700 text-sm text-center">
                        <svg class="animate-spin w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Procesando...
                    </div>
                </div>

                @php($paxCount = count($pasajeros ?? []))
                @php($today = date('Y-m-d'))

                {{-- Formulario --}}
                <form wire:submit.prevent="guardarCotizacion" class="px-6 pb-6 space-y-5">
                    {{-- NUEVO: Región / Destino (País) / Origen (País) --}}
                    <div class="grid grid-cols-1 gap-4">
                        {{-- Región --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1">Región</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-orange-500">🌎</span>
                                <select
                                    class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="region_id">
                                    <option value="">Seleccionar región...</option>
                                    @foreach($regiones as $r)
                                        <option value="{{ $r->id }}">{{ $r->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('region_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Destino (País) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1">Destino (País)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-orange-500">📍</span>
                                <select
                                    class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="destino_pais_id">
                                    <option value="">Seleccionar destino...</option>
                                    @foreach($paises as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('destino_pais_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- País de origen --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1">País de origen</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-orange-500">🧭</span>
                                <select
                                    class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="origen_pais_id">
                                    <option value="">Seleccionar país...</option>
                                    @foreach($paises as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('origen_pais_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Fechas con validación de fechas pasadas --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Fecha de viaje</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="date"
                                    min="{{ $today }}"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="fecha_salida"
                                    placeholder="Fecha de salida">
                                <label class="text-xs text-gray-500 mt-1 block">Salida</label>
                            </div>
                            <div>
                                <input type="date"
                                    min="{{ $today }}"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="fecha_regreso"
                                    placeholder="Fecha de regreso">
                                <label class="text-xs text-gray-500 mt-1 block">Regreso</label>
                            </div>
                        </div>
                        @error('fecha_salida') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        @error('fecha_regreso') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tipo de viaje --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Tipo de viaje</label>
                        <select
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                            wire:model.defer="tipo_viaje_id">
                            <option value="">Seleccionar tipo...</option>
                            @foreach($tiposViaje as $tv)
                                <option value="{{ $tv->id }}">{{ $tv->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_viaje_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    {{-- Contacto --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1">E-mail</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-orange-500">@</span>
                                <input type="email"
                                    placeholder="tu@email.com"
                                    class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="correo_contacto">
                            </div>
                            @error('correo_contacto') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1">Teléfono</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-orange-500">📞</span>
                                <input type="text" placeholder="Ej: 3001234567"
                                    class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    wire:model.defer="telefono_contacto">
                            </div>
                            @error('telefono_contacto') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Pasajeros: control ± y edades inline --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-2">Cantidad de pasajeros</label>
                        <div class="flex items-center justify-center gap-6">
                            <button type="button"
                                wire:click="removerPasajero"
                                @disabled($paxCount <= 1)
                                class="w-10 h-10 rounded-full bg-orange-100 text-orange-700 text-xl font-bold flex items-center justify-center hover:bg-orange-200 disabled:opacity-40 disabled:cursor-not-allowed">
                                −
                            </button>

                            <span class="text-lg font-semibold w-8 text-center select-none">{{ $paxCount }}</span>

                            <button type="button"
                                wire:click="agregarPasajero"
                                @disabled($paxCount >= 10)
                                class="w-10 h-10 rounded-full bg-orange-100 text-orange-700 text-xl font-bold flex items-center justify-center hover:bg-orange-200 disabled:opacity-40 disabled:cursor-not-allowed">
                                +
                            </button>
                        </div>

                        {{-- Edades --}}
                        <div class="mt-3 flex flex-wrap gap-2 justify-center">
                            @foreach(($pasajeros ?? []) as $i => $p)
                                <input type="number" min="0" max="120"
                                    class="w-16 px-2 py-2 border border-gray-300 rounded-md text-center text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    placeholder="{{ $i + 1 }}"
                                    wire:model.defer="pasajeros.{{ $i }}.edad"
                                    wire:key="pax-edad-{{ $i }}">
                            @endforeach
                        </div>

                        @if($errors->has('pasajeros.*.edad'))
                            <div class="text-red-600 text-xs mt-1 text-center">Por favor ingresa edades válidas</div>
                        @endif
                    </div>

                    {{-- Botón principal --}}
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 rounded-lg text-lg shadow-lg hover:scale-[1.02] transition">
                        COTIZAR GRATIS
                    </button>

                    <p class="text-xs text-gray-600 text-center">Al cotizar estás aceptando nuestros T&C</p>
                </form>
            </div>
        </div>
    </div>
</div>
