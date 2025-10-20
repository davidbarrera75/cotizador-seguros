<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SliderImage;
use Illuminate\Support\Facades\Storage;

class SliderManager extends Component
{
    use WithFileUploads;
    
    // Campos que vienen del form
    public $archivo;
    public $title;
    public $sort = 0;
    public $active = true;

    // Validación
    protected $rules = [
        'archivo' => 'required|image|max:5120', // obligatorio, imagen <= 5 MB
        'title'   => 'nullable|string|max:255',
        'sort'    => 'nullable|integer|min:0',
        'active'  => 'boolean',
    ];

    // Crear nuevo slider
    public function save()
    {
        $this->validate();

        // Guardar imagen en storage/app/public/slider
        $path = $this->archivo->store('slider', 'public');

        SliderImage::create([
            'title'  => $this->title,
            'path'   => $path,
            'sort'   => $this->sort,
            'active' => $this->active ?? true,
        ]);

        session()->flash('message', '✅ Imagen subida con éxito.');

        // Resetea los campos del form
        $this->reset(['archivo', 'title', 'sort', 'active']);
        $this->active = true; // volver a true por defecto
    }

    // Borrar una imagen
    public function delete($id)
    {
        $img = SliderImage::findOrFail($id);

        // Borra archivo físico si existe
        if ($img->path && Storage::disk('public')->exists($img->path)) {
            Storage::disk('public')->delete($img->path);
        }

        $img->delete();

        session()->flash('message', '🗑️ Imagen eliminada correctamente.');
    }

    // Activar/desactivar con toggle
    public function toggleActive($id)
    {
        $img = SliderImage::findOrFail($id);

        $img->active = !$img->active;
        $img->save();

        session()->flash('message', $img->active ? '✅ Imagen activada.' : '⛔ Imagen desactivada.');
    }

    public function render()
    {
        return view('livewire.slider-manager', [
            'imagenes' => SliderImage::orderBy('sort')->get(),
        ]);
    }
}