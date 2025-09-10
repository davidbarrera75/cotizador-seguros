<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sticky top-6">
    <div class="space-y-5">
        <!-- Header con resumen actual -->
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Ajustar Cotización</h3>
            <div class="text-sm text-gray-600">
                <span class="font-medium">#{{ $cotizacion->id }}</span> • 
                <span>{{ $this->calculatedDays }} días</span> • 
                <span>{{ count($pasajeros) }} {{ count($pasajeros) == 1 ? 'persona' : 'personas' }}</span>
            </div>
        </div>

        <!-- Fechas de viaje -->
        <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700">Fechas de viaje</label>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <input type="date" wire:model.live="fecha_salida"
                           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_salida') border-red-500 @enderror">
                    <label class="text-xs text-gray-500 mt-1 block">Salida</label>
                    @error('fecha_salida') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <input type="date" wire:model.live="fecha_regreso"
                           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_regreso') border-red-500 @enderror">
                    <label class="text-xs text-gray-500 mt-1 block">Regreso</label>
                    @error('fecha_regreso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            @if($this->calculatedDays > 0)
                <div class="text-xs text-blue-600">
                    {{ $this->calculatedDays }} días de viaje
                </div>
            @endif
        </div>

        <!-- Gestión de pasajeros -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium text-gray-700">Pasajeros</label>
                <div class="flex items-center gap-2">
                    <button wire:click="removePasajero" type="button" @disabled(count($pasajeros) <= 1)
                            class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <span class="text-sm font-medium min-w-[2rem] text-center">{{ count($pasajeros) }}</span>
                    <button wire:click="addPasajero" type="button" @disabled(count($pasajeros) >= 10)
                            class="w-7 h-7 rounded-full bg-blue-100 hover:bg-blue-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Lista de pasajeros -->
            <div class="space-y-2 max-h-40 overflow-y-auto">
                @foreach($pasajeros as $index => $pasajero)
                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-md" wire:key="pasajero-{{ $index }}">
                        <span class="text-xs text-gray-500 w-4">{{ $index + 1 }}</span>
                        <input type="number" wire:model.blur="pasajeros.{{ $index }}.edad" 
                               placeholder="Edad" min="0" max="100"
                               class="flex-1 rounded border border-gray-300 px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('pasajeros.'.$index.'.edad') border-red-500 @enderror">
                        <button wire:click="removePasajeroIndex({{ $index }})" type="button" 
                                @disabled(count($pasajeros) <= 1)
                                class="text-red-400 hover:text-red-600 disabled:opacity-30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @error('pasajeros.'.$index.'.edad') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                @endforeach
            </div>
        </div>

        <!-- Campos opcionales colapsables -->
        <div>
            <button wire:click="$toggle('showAdvanced')" type="button"
                    class="flex items-center justify-between w-full text-sm text-gray-600 hover:text-gray-800">
                <span>Cambiar destino o tipo de viaje</span>
                <svg class="w-4 h-4 transition-transform {{ $showAdvanced ? 'rotate-180' : '' }}">
                    <path stroke="currentColor" stroke-width="2" d="M6 9l6 6 6-6" fill="none"/>
                </svg>
            </button>

            @if($showAdvanced)
                <div class="mt-3 space-y-3">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Destino</label>
                        <select wire:model="destino_id" 
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('destino_id') border-red-500 @enderror">
                            <option value="">Seleccionar destino...</option>
                            @foreach($destinos as $destino)
                                <option value="{{ $destino->id }}">{{ $destino->nombre }}</option>
                            @endforeach
                        </select>
                        @error('destino_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tipo de viaje</label>
                        <select wire:model="tipo_viaje_id"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo_viaje_id') border-red-500 @enderror">
                            <option value="">Seleccionar tipo...</option>
                            @foreach($tiposViaje as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_viaje_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif
        </div>

        <!-- Botón de recotización -->
        <div class="pt-4 border-t border-gray-100">
            <button wire:click="recotizar" type="button" @disabled($loading)
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                @if($loading)
                    <span class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Buscando...
                    </span>
                @else
                    Buscar Nuevos Planes
                @endif
            </button>
        </div>

        <!-- Indicador de cambios -->
        @if($this->hasChanges)
            <div class="text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-md p-2">
                <div class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Hay cambios sin aplicar</span>
                </div>
            </div>
        @endif

        <!-- Mostrar errores de sesión -->
        @if (session()->has('error'))
            <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-md p-2">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>