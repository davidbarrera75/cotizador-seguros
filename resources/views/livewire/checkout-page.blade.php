<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

    @php
        // Helpers de estilos para inputs/selects (Tailwind)
        $input  = 'w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500';
        $select = $input . ' pr-9 appearance-none'; // añadimos espacio para el chevron

        // --- utilidades del resumen (igual que antes) ---
        $paisesDisplay = [
            'CO'=>'Colombia','AR'=>'Argentina','BO'=>'Bolivia','BR'=>'Brasil','CL'=>'Chile','EC'=>'Ecuador','PE'=>'Perú',
            'MX'=>'México','US'=>'Estados Unidos','ES'=>'España','UY'=>'Uruguay','PY'=>'Paraguay'
        ];
        $po = strtoupper((string)($cotizacion->pais_origen ?? 'CO'));
        $paisOrigenNombre = $paisesDisplay[$po] ?? $po;

        $destinoNombre   = optional($cotizacion->destino)->nombre ?? ('Destino #'.$cotizacion->destino_id);
        $tipoViajeNombre = optional($cotizacion->tipoViaje)->nombre ?? ('Tipo #'.$cotizacion->tipo_viaje_id);

        $fs = $cotizacion->fecha_salida ? \Carbon\Carbon::parse($cotizacion->fecha_salida) : null;
        $fr = $cotizacion->fecha_regreso ? \Carbon\Carbon::parse($cotizacion->fecha_regreso) : null;

        $dias = 1;
        if ($fs && $fr) { $dias = max(1, $fs->diffInDays($fr) + 1); }

        $pasajerosCount = $cotizacion->pasajeros()->count();
        $edades = $cotizacion->pasajeros()->pluck('edad')->filter()->values()->all();
        $edadesTxt = empty($edades) ? '—' : implode(', ', $edades);

        $m = $monedaMostrada ?? 'COP';
        $dec = $m === 'USD' ? 2 : 0;
        $sym = $m === 'USD' ? 'US$' : '$';
        $precioFmt = isset($precioMostrado) && $precioMostrado !== null
            ? $sym . number_format((float)$precioMostrado, $dec)
            : '—';
    @endphp

    <div class="md:grid md:grid-cols-12 md:gap-6">
        <!-- Resumen izquierdo -->
        <aside class="md:col-span-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 md:sticky md:top-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Resumen de tu cotización</h2>

                <dl class="divide-y divide-gray-100">
                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Cotización</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">#{{ $cotizacion->id }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">País de origen</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">{{ $paisOrigenNombre }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Destino</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">{{ $destinoNombre }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Tipo de viaje</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">{{ $tipoViajeNombre }}</dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Fechas</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">
                            {{ $fs ? $fs->format('d M Y') : '—' }} &rarr; {{ $fr ? $fr->format('d M Y') : '—' }}
                            <span class="block text-xs text-gray-500">Duración: {{ $dias }} día(s)</span>
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Pasajeros</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">
                            {{ $pasajerosCount }}
                            <span class="block text-xs text-gray-500">Edades: {{ $edadesTxt }}</span>
                        </dd>
                    </div>

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Moneda</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">{{ $m }}</dd>
                    </div>

                    @isset($plan)
                        <div class="py-3 grid grid-cols-3 gap-3">
                            <dt class="text-sm text-gray-500 col-span-1">Plan</dt>
                            <dd class="text-sm font-medium text-gray-900 col-span-2">
                                {{ $plan->nombre }}
                                @if(optional($plan->aseguradora)->nombre)
                                    <span class="block text-xs text-gray-500">Aseguradora: {{ $plan->aseguradora->nombre }}</span>
                                @endif
                            </dd>
                        </div>

                        <div class="py-3 grid grid-cols-3 gap-3">
                            <dt class="text-sm text-gray-500 col-span-1">Precio</dt>
                            <dd class="text-sm font-semibold text-gray-900 col-span-2">
                                {{ $precioFmt }}
                            </dd>
                        </div>
                    @endisset

                    <div class="py-3 grid grid-cols-3 gap-3">
                        <dt class="text-sm text-gray-500 col-span-1">Contacto</dt>
                        <dd class="text-sm font-medium text-gray-900 col-span-2">
                            {{ $cotizacion->correo_contacto ?? '—' }}
                            @if(!empty($cotizacion->telefono_contacto))
                                <span class="block text-xs text-gray-500">{{ $cotizacion->telefono_contacto }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                @if(($monedaMostrada ?? 'COP') === 'USD')
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-900">
                        Tipo de cambio aplicado: <strong>1 USD = {{ number_format((float)($tasaUsdCop ?? 0), 2) }} COP</strong>.
                    </div>
                @else
                    <div class="mt-4 p-3 bg-gray-50 border border-gray-100 rounded-lg text-xs text-gray-700">
                        Precios mostrados en <strong>COP</strong>. Si el país de origen no es Colombia, se mostrarán en <strong>USD</strong>.
                    </div>
                @endif

                <div class="mt-4 text-[11px] leading-4 text-gray-500">
                    Si necesitas cambiar algún dato (fechas, destino, etc.) vuelve al formulario anterior y repite la búsqueda.
                </div>
            </div>
        </aside>

        <!-- Formulario derecho -->
        <main class="md:col-span-8 mt-6 md:mt-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Datos de los pasajeros</h2>

                <form wire:submit.prevent="saveCheckout" class="space-y-6">
                    @csrf

                    <div class="space-y-5">
                        @foreach(($pasajerosData ?? []) as $i => $p)
                            <div class="rounded-lg border border-gray-100 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-medium text-gray-800">Pasajero {{ $i + 1 }}</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Nombre</label>
                                        <input type="text" placeholder="Ej: Ana"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.nombre"
                                               aria-invalid="@error("pasajerosData.$i.nombre") true @enderror">
                                        @error("pasajerosData.$i.nombre")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Apellido</label>
                                        <input type="text" placeholder="Ej: Pérez"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.apellido">
                                        @error("pasajerosData.$i.apellido")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Fecha de nacimiento</label>
                                        <input type="date"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.fecha_nacimiento">
                                        @error("pasajerosData.$i.fecha_nacimiento")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Tipo de documento</label>
                                        <div class="relative">
                                            <select class="{{ $select }}"
                                                    wire:model.defer="pasajerosData.{{ $i }}.tipo_documento">
                                                <option value="">Seleccione…</option>
                                                @foreach($tiposDeDocumento as $td)
                                                    <option value="{{ $td }}">{{ $td }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        @error("pasajerosData.$i.tipo_documento")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Número de documento</label>
                                        <input type="text" placeholder="Ej: 1234567890"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.numero_documento">
                                        @error("pasajerosData.$i.numero_documento")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Dirección</label>
                                        <input type="text" placeholder="Calle, número, apto"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.direccion">
                                        @error("pasajerosData.$i.direccion")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">País de residencia</label>
                                        <div class="relative">
                                            <select class="{{ $select }}"
                                                    wire:model.defer="pasajerosData.{{ $i }}.pais">
                                                <option value="">Seleccione…</option>
                                                @foreach($paises as $px)
                                                    <option value="{{ $px }}">{{ $px }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        @error("pasajerosData.$i.pais")<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm text-gray-700 mb-1">Contacto de emergencia — Nombre</label>
                                        <input type="text" placeholder="Ej: María López"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.contacto_emergencia_nombre">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Contacto de emergencia — Teléfono</label>
                                        <input type="text" placeholder="Ej: +57 300 123 4567"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.contacto_emergencia_telefono">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Contacto de emergencia — Email</label>
                                        <input type="email" placeholder="Ej: maria@email.com"
                                               class="{{ $input }}"
                                               wire:model.defer="pasajerosData.{{ $i }}.contacto_emergencia_email">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        @if (session('success_message'))
                            <span class="text-green-600 text-sm">{{ session('success_message') }}</span>
                        @endif
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 rounded-lg bg-green-600 text-white font-semibold shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Confirmar y continuar por WhatsApp
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
