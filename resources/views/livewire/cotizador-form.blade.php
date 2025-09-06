<div class="max-w-5xl mx-auto p-6 md:p-8">

    {{-- Título --}}
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Cotizador de Seguros de Viaje</h1>

    {{-- Tips / ayuda --}}
    <div class="mb-6 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">
        <div class="font-semibold mb-1">Consejos rápidos</div>
        <ul class="list-disc pl-5 space-y-1">
            <li><strong>Moneda:</strong> si el <em>País de origen</em> es <strong>CO (Colombia)</strong>, verás los precios en <strong>COP</strong>. Para cualquier otro país, en <strong>USD</strong>.</li>
            <li>El <em>Destino</em> define la cobertura/planes disponibles según tu configuración.</li>
            <li>Las fechas deben ser válidas (la de regreso posterior a la de salida).</li>
            <li>Puedes añadir o quitar pasajeros; la edad impacta en los planes disponibles.</li>
        </ul>
    </div>

    {{-- Mensaje flash --}}
    @if (session('message'))
        <div class="mb-6 rounded-lg bg-emerald-50 text-emerald-700 p-3">
            {{ session('message') }}
        </div>
    @endif

    {{-- Estado de carga Livewire --}}
    <div wire:loading class="mb-4 rounded-lg border border-gray-200 bg-white p-3 text-gray-600">
        Procesando…
    </div>

    {{-- Errores globales (opcional) --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 text-red-700 p-3 text-sm">
            <strong>Por favor corrige los siguientes campos:</strong>
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="guardarCotizacion" class="space-y-8">

        {{-- FILA: País de origen | Destino (2 columnas) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- País de origen --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">País de origen</label>
                <select class="w-full border rounded px-3 py-2" wire:model.defer="pais_origen">
                    @foreach($paises as $code => $nombre)
                        <option value="{{ $code }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                @error('pais_origen') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Destino --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Destino</label>
                <select class="w-full border rounded px-3 py-2" wire:model.defer="destino_id">
                    <option value="">Selecciona…</option>
                    @foreach($destinos as $d)
                        <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                    @endforeach
                </select>
                @error('destino_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- FILA: Tipo de viaje | (espacio libre futuro) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tipo de viaje --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tipo de viaje</label>
                <select class="w-full border rounded px-3 py-2" wire:model.defer="tipo_viaje_id">
                    <option value="">Selecciona…</option>
                    @foreach($tiposViaje as $tv)
                        <option value="{{ $tv->id }}">{{ $tv->nombre }}</option>
                    @endforeach
                </select>
                @error('tipo_viaje_id') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
            <div></div>
        </div>

        {{-- FILA: Fechas (salida / regreso) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Fecha de salida</label>
                <input type="date" class="w-full border rounded px-3 py-2"
                       wire:model.defer="fecha_salida">
                @error('fecha_salida') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Fecha de regreso</label>
                <input type="date" class="w-full border rounded px-3 py-2"
                       wire:model.defer="fecha_regreso">
                @error('fecha_regreso') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- FILA: Contacto (correo / teléfono) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Correo de contacto</label>
                <input type="email" class="w-full border rounded px-3 py-2"
                       placeholder="tu@correo.com"
                       wire:model.defer="correo_contacto">
                @error('correo_contacto') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Teléfono (opcional)</label>
                <input type="text" class="w-full border rounded px-3 py-2"
                       placeholder="Ej: 3001234567"
                       wire:model.defer="telefono_contacto">
                @error('telefono_contacto') <div class="text-red-600 text-xs mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PASAJEROS (rediseñado) --}}
        <section class="rounded-xl border border-gray-200 bg-white p-5">
            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-semibold text-gray-900">Pasajeros</h2>
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs text-gray-700">
                        {{ is_iterable($pasajeros ?? []) ? count($pasajeros) : 0 }} total
                    </span>
                </div>
                <div class="text-xs text-gray-500">
                    Puedes agregar o quitar pasajeros. Máximo recomendado: 10.
                </div>
            </div>

            <div class="space-y-4">
                @foreach(($pasajeros ?? []) as $i => $p)
                    <div class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm" wire:key="pax-{{ $i }}">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 grid place-items-center rounded-full bg-blue-50 text-blue-700 text-sm font-semibold">
                                    {{ $i + 1 }}
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">
                                    Pasajero #{{ $i + 1 }}
                                </h3>
                            </div>

                            @if($i > 0)
                                <button type="button"
                                        class="inline-flex items-center rounded-md border border-red-200 bg-white px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50"
                                        wire:click="removerPasajero({{ $i }})">
                                    Eliminar
                                </button>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Edad --}}
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Edad</label>
                                <input type="number" min="0" max="120" class="w-full border rounded px-3 py-2"
                                       placeholder="Ej: 32"
                                       wire:model.defer="pasajeros.{{ $i }}.edad">
                                @error("pasajeros.$i.edad")
                                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Espacio para futuros campos (nombre, documento, etc.) --}}
                            <div class="hidden md:block"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-between">
                <p class="text-xs text-gray-500">
                    Consejo: si todos tienen edades similares, comienza llenando la del primer pasajero y luego agrega más.
                </p>
                <button type="button"
                        class="inline-flex items-center rounded bg-blue-600 px-3 py-2 text-white text-sm font-semibold hover:bg-blue-700"
                        wire:click="agregarPasajero">
                    + Agregar pasajero
                </button>
            </div>
        </section>

        {{-- Acciones --}}
        <div class="flex items-center justify-end gap-3">
            <button type="submit"
                    class="inline-flex items-center rounded bg-green-600 px-4 py-2.5 text-white font-semibold hover:bg-green-700">
                Buscar planes
            </button>
        </div>
    </form>
</div>
