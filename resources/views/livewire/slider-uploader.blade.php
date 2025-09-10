<div class="space-y-6">
    {{-- Mensajes --}}
    @if (session('message'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Formulario de subida --}}
    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">

        {{-- Archivo --}}
        <div>
            <label class="block font-semibold">Imagen (máx. 5MB)</label>
            <input type="file" wire:model="archivo" class="border rounded w-full">
            @error('archivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div wire:loading wire:target="archivo" class="text-sm text-gray-500">Subiendo...</div>
        </div>

        {{-- Título --}}
        <div>
            <label class="block font-semibold">Título / Pie de foto</label>
            <input type="text" wire:model.defer="title" class="border rounded w-full">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Orden --}}
        <div>
            <label class="block font-semibold">Orden</label>
            <input type="number" wire:model.defer="sort" class="border rounded w-full">
        </div>

        {{-- Estado --}}
        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model.defer="active" id="activo">
            <label for="activo">Activo</label>
        </div>

        {{-- Botón --}}
        <button type="submit"
            class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">
            Subir Imagen
        </button>
    </form>

    {{-- Listado de imágenes --}}
    <div class="mt-6">
        <h3 class="font-bold mb-3">Imágenes actuales</h3>
        <div class="grid grid-cols-2 gap-4">
            @foreach($imagenes as $img)
                <div class="relative border rounded overflow-hidden">
                    <img src="{{ asset('storage/'.$img->path) }}" class="w-full h-32 object-cover">
                    <div class="p-2 text-sm">
                        <p class="font-semibold">{{ $img->title ?? 'Sin título' }}</p>
                        <p class="text-gray-500">Orden: {{ $img->sort }}</p>
                        <p class="{{ $img->active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $img->active ? 'Activo' : 'Inactivo' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>