<div class="max-w-4xl mx-auto p-8 bg-gray-50">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Completa los Datos de los Viajeros</h1>

    <form wire:submit.prevent="saveCheckout" class="space-y-8">
        @foreach($pasajerosData as $index => $pasajero)
        <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
            <h2 class="text-xl font-bold mb-4 text-gray-900">
                Pasajero {{ $index + 1 }} ({{ $this->cotizacion->pasajeros[$index]->edad }} años)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre_{{ $index }}" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="nombre_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="apellido_{{ $index }}" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input id="apellido_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.apellido" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="fecha_nacimiento_{{ $index }}" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                    <input id="fecha_nacimiento_{{ $index }}" type="date" wire:model="pasajerosData.{{ $index }}.fecha_nacimiento" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="tipo_documento_{{ $index }}" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                    <select id="tipo_documento_{{ $index }}" wire:model="pasajerosData.{{ $index }}.tipo_documento" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione...</option>
                        @foreach($tiposDeDocumento as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="numero_documento_{{ $index }}" class="block text-sm font-medium text-gray-700">Número de Documento</label>
                    <input id="numero_documento_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.numero_documento" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="direccion_{{ $index }}" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input id="direccion_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.direccion" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="pais_{{ $index }}" class="block text-sm font-medium text-gray-700">País de Residencia</label>
                    <select id="pais_{{ $index }}" wire:model="pasajerosData.{{ $index }}.pais" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccione un país...</option>
                        @foreach($paises as $code => $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 mt-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-700">Datos Contacto de Emergencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="contacto_nombre_{{ $index }}" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input id="contacto_nombre_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.contacto_emergencia_nombre" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="contacto_telefono_{{ $index }}" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input id="contacto_telefono_{{ $index }}" type="text" wire:model="pasajerosData.{{ $index }}.contacto_emergencia_telefono" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label for="contacto_email_{{ $index }}" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="contacto_email_{{ $index }}" type="email" wire:model="pasajerosData.{{ $index }}.contacto_emergencia_email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="pt-4">
            <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-md shadow-lg hover:bg-green-700">
                Confirmar Compra
            </button>
        </div>
    </form>
</div>