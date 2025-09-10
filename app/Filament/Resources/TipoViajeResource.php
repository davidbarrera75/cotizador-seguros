<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoViajeResource\Pages;
use App\Models\TipoViaje;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TipoViajeResource extends Resource
{
    protected static ?string $model = TipoViaje::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Tipo Viajes';
    protected static ?string $pluralModelLabel = 'Tipo Viajes';
    protected static ?string $modelLabel = 'Tipo de viaje';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nombre')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            Toggle::make('activo')
                ->label('Activo')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),

                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // Oculta "Eliminar" cuando el tipo está referenciado por cotizaciones
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->visible(fn ($record) => ! $record->cotizacions()->exists()),
            ])
            ->bulkActions([
                // Importante: quitamos el DeleteBulkAction para evitar errores SQL en lote
                Tables\Actions\BulkActionGroup::make([
                    // (deja vacío o agrega otras acciones seguras)
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTipoViajes::route('/'),
            'create' => Pages\CreateTipoViaje::route('/create'),
            'edit' => Pages\EditTipoViaje::route('/{record}/edit'),
        ];
    }
}
