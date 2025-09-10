<?php

namespace App\Filament\Resources\TipoViajeResource\Pages;

use App\Filament\Resources\TipoViajeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;

class EditTipoViaje extends EditRecord
{
    protected static string $resource = TipoViajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->visible(fn ($record) => ! $record->cotizacions()->exists()) // 👈 ocultar si está en uso
                ->requiresConfirmation()
                ->action(function ($record) {
                    try {
                        $record->delete();

                        Notification::make()
                            ->title('Tipo de viaje eliminado')
                            ->success()
                            ->send();

                        $this->redirect(static::getResource()::getUrl('index'));
                    } catch (QueryException $e) {
                        // 1451: violación de FK (hay cotizaciones asociadas)
                        if ((int) ($e->errorInfo[1] ?? 0) === 1451) {
                            Notification::make()
                                ->title('No se puede eliminar')
                                ->body('Este “Tipo de viaje” está siendo usado por cotizaciones. Desactívalo o reasigna las cotizaciones antes de eliminar.')
                                ->danger()
                                ->send();
                            return;
                        }

                        throw $e;
                    }
                }),
        ];
    }
}
