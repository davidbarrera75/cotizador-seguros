<?php

namespace App\Filament\Resources\TipoViajeResource\Pages;

use App\Filament\Resources\TipoViajeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoViajes extends ListRecords
{
    protected static string $resource = TipoViajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
