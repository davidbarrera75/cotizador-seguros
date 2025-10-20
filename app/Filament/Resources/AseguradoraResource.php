<?php

namespace App\Filament\Resources;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\AseguradoraResource\Pages;
use App\Filament\Resources\AseguradoraResource\RelationManagers;
use App\Models\Aseguradora;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AseguradoraResource extends Resource
{
    protected static ?string $model = Aseguradora::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')->required(),
                FileUpload::make('logo')
->disk('public') // <-- ¡LÍNEA AÑADIDA!
->image()->directory('logos-aseguradoras'),
                Toggle::make('activo')->required()->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),
                TextColumn::make('nombre')->searchable(),
                IconColumn::make('activo')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAseguradoras::route('/'),
            'create' => Pages\CreateAseguradora::route('/create'),
            'edit' => Pages\EditAseguradora::route('/{record}/edit'),
        ];
    }
}
