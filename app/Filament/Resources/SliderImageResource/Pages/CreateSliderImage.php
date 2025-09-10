<?php

namespace App\Filament\Resources\SliderImageResource\Pages;

use App\Filament\Resources\SliderImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSliderImage extends CreateRecord
{
    protected static string $resource = SliderImageResource::class;

    // Limitar a 4 activas (regla amigable)
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['active'] ?? false) === true) {
            $countActive = \App\Models\SliderImage::where('active', true)->count();
            if ($countActive >= 4) {
                $this->notify('danger', 'Ya hay 4 imágenes activas. Desactiva alguna para activar esta.');
                $data['active'] = false;
            }
        }
        return $data;
    }
}
