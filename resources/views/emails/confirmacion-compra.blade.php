<div class="max-w-5xl mx-auto p-6 md:p-8">

    @php
        use Carbon\Carbon;

        // Fechas / pax / edades
        $fs   = $cotizacion->fecha_salida ? Carbon::parse($cotizacion->fecha_salida) : null;
        $fr   = $cotizacion->fecha_regreso ? Carbon::parse($cotizacion->fecha_regreso) : null;
        $dias = ($fs && $fr) ? max(1, $fr->diffInDays($fs) + 1) : null;
        $pax  = $cotizacion->pasajeros()->count();
        $edadMax = $cotizacion->pasajeros()->max('edad') ?? 0;

        // Nombre del país desde código ISO-2 guardado en cotizacions.pais_origen
        $paisCode = strtoupper($cotizacion->pais_origen ?? 'CO');
        $paisMap  = [
            // LatAm + frecuentes (amplía cuando quieras)
            'CO'=>'Colombia','AR'=>'Argentina','BO'=>'Bolivia','BR'=>'Brasil','CL'=>'Chile','EC'=>'Ecuador',
            'PY'=>'Paraguay','PE'=>'Perú','UY'=>'Uruguay','VE'=>'Venezuela','MX'=>'México','CR'=>'Costa Rica',
            'PA'=>'Panamá','GT'=>'Guatemala','SV'=>'El Salvador','HN'=>'Honduras','NI'=>'Nicaragua',
            'US'=>'Estados Unidos','CA'=>'Canadá','ES'=>'España','FR'=>'Francia','IT'=>'Italia','DE'=>'Alemania',
            'GB'=>'Reino Unido','PT'=>'Portugal','NL'=>'Países Bajos','BE'=>'Bélgica','CH'=>'Suiza',
        ];
        $paisNombre = $paisMap[$paisCode] ?? $paisCode;

        // Moneda (el componente ya define $moneda, pero por seguridad lo derivamos también aquí)
        $moneda = isset($moneda) ? $moneda : ($paisCode === 'CO' ? 'COP' : 'USD');

        // Formateador por moneda
        $fmtMoney = function($v) use ($moneda) {
            $v = (float) $v;
            return $moneda === 'COP'
                ? '$' . number_format($v, 0, ',', '.') . ' COP'
                : '$' . number_format($v, 2, '.', ',') . ' USD';
        };
    @endphp

    <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
            Planes disponibles
        </h1>
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
            @if($fs && $fr)
                <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                    📅 {{ $fs->format('d M Y') }} → {{ $fr->format('d M Y') }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                    ⏱️ {{ $dias }} {{ \Illuminate\Support\Str::plural('día', $dias) }}
                </span>
            @endif
            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                👥 {{ $pax }} {{ \Illuminate\Support\Str::plural('pasajero', $pax) }}
            </span>
            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                🎂 Edad máx.: {{ $edadMax }}
            </span>
            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                🏁 País de origen: {{ $paisNombre }} ({{ $paisCode }})
            </span>
            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                💱 Moneda: {{ $moneda }}
            </span>
        </div>
    </div>

    {{-- Estado de carga Livewire (si tienes acciones que recargan la lista) --}}
    <div wire:loading class="mb-6 rounded-xl border border-gray-200 bg-white p-5 text-gray-600">
        Cargando planes…
    </div>

    @if(!empty($planesEncontrados) && count($planesEncontrados))
        <div class="space-y-5">
            @foreach($planesEncontrados as $plan)
                @php
                    $aseg = optional($plan->aseguradora);
                    $tarifa = $plan->tarifas->first(); // ya viene filtrada/ordenada por el componente
                    $diasTarifa = optional($tarifa)->dias;
                    $precio = $plan->precio_final ?? optional($tarifa)->precio;
                @endphp

                <article
                    wire:key="plan-{{ $plan->id }}"
                    class="group flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm hover:shadow-md transition-shadow"
                    aria-label="Plan {{ $plan->nombre }}"
                >
                    {{-- Izquierda: logo + info --}}
                    <div class="flex items-start gap-4">
                        @if($aseg && $aseg->logo)
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($aseg->logo) }}"
                                alt="Logo {{ $aseg->nombre }}"
                                class="h-12 w-12 object-contain rounded-md bg-white"
                                loading="lazy"
                            >
                        @else
                            <div class="h-12 w-12 rounded-md bg-gray-100 grid place-items-center text-gray-500 text-sm">
                                {{ $aseg? \Illuminate\Support\Str::of($aseg->nombre)->substr(0,2)->upper() : 'NA' }}
                            </div>
                        @endif

                        <div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900 leading-tight">
                                {{ $plan->nombre }}
                            </h2>
                            <p class="text-sm text-gray-600">
                                {{ $aseg->nombre ?? 'Aseguradora no disponible' }}
                            </p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @if($diasTarifa)
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs text-blue-700">
                                        Cobertura: {{ $diasTarifa }} {{ \Illuminate\Support\Str::plural('día', $diasTarifa) }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs text-emerald-700">
                                    Edad máx. plan: {{ $plan->edad_maxima }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Derecha: precio + CTA --}}
                    <div class="text-right md:min-w-[240px]">
                        @if($precio)
                            <div class="text-2xl md:text-3xl font-bold text-blue-600">
                                {{ $fmtMoney($precio) }}
                            </div>
                            @if(isset($dias, $diasTarifa) && $diasTarifa > $dias)
                                <div class="text-[12px] text-gray-500">Tarifa para {{ $diasTarifa }} días</div>
                            @endif
                        @else
                            <div class="text-sm text-gray-500">Precio no disponible</div>
                        @endif

                        <a href="{{ route('checkout', ['cotizacion' => $cotizacion->id, 'plan' => $plan->id]) }}"
                           class="mt-2 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                            Comprar Ahora
                        </a>

                        <div class="mt-2 flex justify-end gap-3 text-xs text-gray-500">
                            @if(!empty($plan->condiciones_url))
                                <a href="{{ $plan->condiciones_url }}" target="_blank" rel="nofollow noopener" class="hover:text-gray-700 underline">
                                    Ver condiciones
                                </a>
                            @endif
                            @if(!empty($plan->brochure_url))
                                <a href="{{ $plan->brochure_url }}" target="_blank" rel="nofollow noopener" class="hover:text-gray-700 underline">
                                    Brochure
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-gray-100 bg-white p-8 text-center shadow-sm">
            <p class="text-lg text-gray-700 mb-2">
                No encontramos planes que coincidan con tu búsqueda.
            </p>
            <p class="text-sm text-gray-500">
                Prueba ajustando las fechas, el destino o el tipo de viaje.
            </p>
            <div class="mt-5">
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    ← Volver
                </a>
            </div>
        </div>
    @endif
</div>