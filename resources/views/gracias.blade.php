<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Gracias por tu compra!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="p-10 bg-white rounded-lg shadow-lg text-center">
        @if (session('success_message'))
        <h1 class="text-3xl font-bold text-green-600 mb-4">¡Compra Exitosa!</h1>
        <p class="text-gray-700 text-lg">{{ session('success_message') }}</p>
        <a href="/" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
            Volver al Inicio
        </a>
        @else
        <h1 class="text-3xl font-bold text-gray-800">Gracias</h1>
        <a href="/" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
            Volver al Inicio
        </a>
        @endif
    </div>
</body>

</html>