<!DOCTYPE html>
<html>

<head>
    <title>Cotización de Seguro</title>
</head>

<body>
    <h2>¡Hola, {{ $datos_seguro['nombre'] ?? 'Cliente' }}!</h2>
    <p>Gracias por usar nuestro cotizador. Aquí tienes los detalles de tu seguro:</p>
    <ul>
        <li><strong>Tipo de Cobertura:</strong> {{ $datos_seguro['cobertura'] ?? 'No especificada' }}</li>
        <li><strong>Costo Anual Estimado:</strong> ${{ number_format($datos_seguro['costo'] ?? 0, 2) }}</li>
        <li><strong>Vehículo Asegurado:</strong> {{ $datos_seguro['vehiculo'] ?? 'No especificado' }}</li>
    </ul>
    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
    <p>Saludos,<br>El equipo de Tu Aseguradora de Confianza</p>
</body>

</html>