<?php

namespace App\Filament\Resources\TipoViajeResource\Pages;

use App\Filament\Resources\TipoViajeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoViaje extends EditRecord
{
    protected static string $resource = TipoViajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
