<?php

namespace App\Filament\Resources\SliderImageResource\Pages;

use App\Filament\Resources\SliderImageResource;
use Filament\Resources\Pages\EditRecord;

class EditSliderImage extends EditRecord
{
    protected static string $resource = SliderImageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['active'] ?? false) === true) {
            $countActive = \App\Models\SliderImage::where('active', true)
                ->where('id', '!=', $this->record->id)
                ->count();

            if ($countActive >= 4) {
                $this->notify('danger', 'Ya hay 4 imágenes activas. Desactiva alguna para activar esta.');
                $data['active'] = false;
            }
        }
        return $data;
    }
}
