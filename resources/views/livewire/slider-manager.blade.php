<div class="space-y-8">
    {{-- Mensaje Flash --}}
    @if (session('message'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg shadow">
            {{ session('message') }}
        </div>
    @endif

    {{-- Formulario de subida --}}
    <form wire:submit.prevent="save" class="space-y-5 bg-white shadow-lg rounded-xl p-6 border" enctype="multipart/form-data">

        <h2 class="text-xl font-bold text-gray-800 mb-2">📤 Subir nueva imagen al slider</h2>

        {{-- Archivo --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Imagen (máx. 5MB)</label>
            <input type="file" wire:model="archivo" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-orange-500">
            @error('archivo') 
                <span class="text-red-600 text-sm">{{ $message }}</span> 
            @enderror

            <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">
                ⏳ Subiendo imagen...
            </div>
        </div>

        {{-- Título --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Título / Pie de foto</label>
            <input type="text" wire:model.defer="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
            @error('title') 
                <span class="text-red-600 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Orden --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Orden</label>
            <input type="number" wire:model.defer="sort" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500">
            <p class="text-xs text-gray-500">0 aparece primero.</p>
        </div>

        {{-- Activo --}}
        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model.defer="active" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
            <label class="text-gray-700">Activo</label>
        </div>

        {{-- Botón Guardar --}}
        <div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-3 rounded-lg shadow hover:scale-[1.02] transition">
                ➕ Guardar Imagen
            </button>
        </div>
    </form>

    {{-- Listado de imágenes --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">🖼️ Imágenes actuales del slider</h2>

        @if($imagenes->isEmpty())
            <p class="text-gray-500">No hay imágenes cargadas aún.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($imagenes as $img)
                    <div class="bg-white rounded-xl shadow-md border overflow-hidden relative">

                        {{-- Imagen preview --}}
                        @if($img->path && Storage::disk('public')->exists($img->path))
                            <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                                Sin imagen
                            </div>
                        @endif

                        {{-- Detalles --}}
                        <div class="p-4 space-y-2">
                            <h3 class="font-semibold text-gray-800 text-sm">{{ $img->title ?? 'Sin título' }}</h3>
                            <p class="text-xs text-gray-500">Orden: {{ $img->sort }}</p>
                            <p class="text-xs {{ $img->active ? 'text-green-600' : 'text-red-600' }}">
                                Estado: {{ $img->active ? 'Activo' : 'Inactivo' }}
                            </p>

                            {{-- Botones --}}
                            <div class="flex space-x-2 mt-3">
                                {{-- Toggle Activo --}}
                                <button wire:click="toggleActive({{ $img->id }})"
                                    class="px-3 py-1 rounded text-xs font-semibold text-white {{ $img->active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                    {{ $img->active ? 'Desactivar' : 'Activar' }}
                                </button>

                                {{-- Eliminar --}}
                                <button wire:click="delete({{ $img->id }})"
                                    class="px-3 py-1 rounded text-xs font-semibold bg-gray-700 text-white hover:bg-gray-800">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>