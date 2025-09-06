@component('mail::message')
# Nueva compra #{{ $cotizacion->id }}

**Fecha salida:** {{ \Carbon\Carbon::parse($cotizacion->fecha_salida)->format('d/m/Y') }}  
**Fecha regreso:** {{ \Carbon\Carbon::parse($cotizacion->fecha_regreso)->format('d/m/Y') }}  
**Días:** {{ max(1, \Carbon\Carbon::parse($cotizacion->fecha_regreso)->diffInDays(\Carbon\Carbon::parse($cotizacion->fecha_salida)) + 1) }}

**Destino:** {{ $destinoNombre ?? $cotizacion->destino_id }}  
**Tipo de viaje:** {{ $tipoViajeNombre ?? $cotizacion->tipo_viaje_id }}  
**País de origen:** {{ $paisNombre }} ({{ strtoupper($cotizacion->pais_origen ?? 'CO') }})  
**Moneda:** {{ $moneda }}

**Contacto:** {{ $cotizacion->correo_contacto }}  
**Teléfono:** {{ $cotizacion->telefono_contacto }}

---

## Pasajeros
@php $i = 1; @endphp
@foreach($cotizacion->pasajeros as $p)
- **#{{ $i++ }}** — Edad: {{ $p->edad }} @if($p->nombre || $p->apellido) — {{ trim(($p->nombre ?? '').' '.($p->apellido ?? '')) }} @endif
  @if($p->tipo_documento || $p->numero_documento)
  — Doc: {{ $p->tipo_documento }} {{ $p->numero_documento }}
  @endif
  @if($p->pais) — País residencia: {{ $p->pais }} @endif
@endforeach

---

## Plan seleccionado
@if($plan)
**Plan:** {{ $plan->nombre }}  
@if($plan->aseguradora) **Aseguradora:** {{ $plan->aseguradora->nombre }} @endif
@endif

@if($tarifa)
**Tarifa:** {{ $tarifa->dias }} días — Precio: 
@if($moneda === 'COP')
${{ number_format($tarifa->precio, 0, ',', '.') }} COP
@else
${{ number_format($tarifa->precio, 2, '.', ',') }} USD
@endif
@endif

@component('mail::button', ['url' => url('/checkout/'.$cotizacion->id)])
Ver cotización
@endcomponent

Gracias,  
{{ config('app.name') }}
@endcomponent
