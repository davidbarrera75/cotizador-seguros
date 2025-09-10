<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SliderImage;

class SliderUploader extends Component
{
    use WithFileUploads;

    public $archivo;
    public $title;
    public $sort = 0;
    public $active = true;

    protected function rules()
    {
        return [
            'archivo' => 'required|image|max:5120', // max 5MB
            'title'   => 'nullable|string|max:255',
            'sort'    => 'nullable|integer|min:0',
            'active'  => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        // almacena el archivo en storage/app/public/slider
        $path = $this->archivo->store('slider', 'public');

        SliderImage::create([
            'title'  => $this->title,
            'path'   => $path,
            'sort'   => $this->sort,
            'active' => $this->active,
        ]);

        session()->flash('message', 'Imagen subida exitosamente ✅');

        // limpiar campos
        $this->reset(['archivo', 'title', 'sort', 'active']);
    }

    public function render()
    {
        return view('livewire.slider-uploader', [
            'imagenes' => SliderImage::orderBy('sort')->get(),
        ]);
    }
}