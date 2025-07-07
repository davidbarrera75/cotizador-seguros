<div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Cotiza tu Asistencia de Viaje</h1>

    {{-- BLOQUE PARA MOSTRAR MENSAJES DE ÉXITO O ERROR --}}
    @if (session()->has('message'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
        {{ session('error') }}
    </div>
    @endif
    {{-- FIN DEL BLOQUE DE MENSAJES --}}

    <form wire:submit.prevent="guardarCotizacion" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="destino" class="block text-sm font-medium text-gray-700">Destino</label>
                <select id="destino" wire:model.live="destino_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecciona un destino</option>
                    @foreach($destinos as $destino)
                    <option value="{{ $destino->id }}">{{ $destino->nombre }}</option>
                    @endforeach
                </select>
                @error('destino_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tipo_viaje" class="block text-sm font-medium text-gray-700">Tipo de Viaje</label>
                <select id="tipo_viaje" wire:model.live="tipo_viaje_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecciona un tipo de viaje</option>
                    @foreach($tiposViaje as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
                @error('tipo_viaje_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="fecha_salida" class="block text-sm font-medium text-gray-700">Fecha de Salida</label>
                <input type="date" id="fecha_salida" wire:model.live="fecha_salida" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                @error('fecha_salida') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="fecha_regreso" class="block text-sm font-medium text-gray-700">Fecha de Regreso</label>
                <input type="date" id="fecha_regreso" wire:model.live="fecha_regreso" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                @error('fecha_regreso') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input type="email" id="correo" wire:model.live="correo_contacto" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                @error('correo_contacto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="tel" id="telefono" wire:model.live="telefono_contacto" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">Edades de los Pasajeros</h3>
            <div class="space-y-4">
                @foreach($pasajeros as $index => $pasajero)
                <div class="flex items-center gap-4">
                    <label class="w-1/3">Pasajero {{ $index + 1 }}</label>
                    <input type="number" wire:model.live="pasajeros.{{ $index }}.edad" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                    <button type="button" wire:click="removerPasajero({{ $index }})" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">-</button>
                </div>
                @error('pasajeros.'.$index.'.edad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @endforeach
            </div>
            <button type="button" wire:click="agregarPasajero" class="mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Añadir Pasajero</button>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white font-bold rounded-md shadow-lg hover:bg-blue-700">Cotizar</button>
        </div>
    </form>
</div>