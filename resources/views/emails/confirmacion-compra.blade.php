<!DOCTYPE html>
<html>

<head>
    <title>Confirmación de Compra</title>
</head>

<body>
    <h1>¡Gracias por tu compra!</h1>
    <p>Hola, hemos recibido los detalles de tu cotización.</p>

    <h2>Resumen del Viaje</h2>
    <ul>
        <li><strong>Destino:</strong> {{ $cotizacion->destino->nombre ?? 'No disponible' }}</li>
        <li><strong>Fechas:</strong> del {{ $cotizacion->fecha_salida }} al {{ $cotizacion->fecha_regreso }}</li>
    </ul>

    <h2>Pasajeros</h2>
    <ul>
        @foreach($cotizacion->pasajeros as $pasajero)
        <li>
            {{ $pasajero['nombre'] ?? $pasajero->nombre ?? '' }}
            {{ $pasajero['apellido'] ?? $pasajero->apellido ?? '' }}
            ({{ $pasajero['edad'] ?? $pasajero->edad ?? '' }} años)
        </li>
        @endforeach
    </ul>

    <p>Pronto nos pondremos en contacto contigo.</p>
</body>

</html>