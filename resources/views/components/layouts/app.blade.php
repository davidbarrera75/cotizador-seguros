<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles {{-- This directive loads Livewire's CSS --}}
</head>

<body class="antialiased bg-gray-100">
    {{-- Your Livewire component will be injected here --}}
    {{ $slot }}

    @livewireScripts {{-- This directive loads Livewire's JavaScript --}}
</body>

</html>