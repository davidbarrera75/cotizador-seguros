<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Repeater;
use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('aseguradora_id')
                    ->relationship('aseguradora', 'nombre')
                    ->required(),
                TextInput::make('nombre')->required(),
                TextInput::make('edad_maxima')->numeric()->required(),
                Toggle::make('activo')->default(true),
                Select::make('destinos')
                    ->multiple()
                    ->relationship(name: 'destinos', titleAttribute: 'nombre')
                    ->preload(),
                Select::make('tiposViaje')
                    ->multiple()
                    ->relationship(name: 'tiposViaje', titleAttribute: 'nombre')
                    ->preload(),

                // --- SECCIÓN DE TARIFAS AÑADIDA ---
                Repeater::make('tarifas')
                    ->relationship()
                    ->schema([
                        TextInput::make('dias')
                            ->numeric()
                            ->required(),
                        TextInput::make('precio')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('edad_maxima')
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
