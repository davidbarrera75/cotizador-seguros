<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderImageResource\Pages;
use App\Models\SliderImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderImageResource extends Resource
{
    protected static ?string $model = SliderImage::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Configuración';
    protected static ?string $navigationLabel = 'Slider (home)';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Imagen')
                ->description('Sube imágenes para el slider de la portada (máx. 4 activas).')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Archivo')
                        ->image()
                        ->directory('slider')
                        ->imageEditor()
                        ->required(),

                    Forms\Components\TextInput::make('title')
                        ->label('Título / pie de foto')
                        ->maxLength(120),

                    Forms\Components\TextInput::make('alt')
                        ->label('Texto alternativo (accesibilidad)')
                        ->maxLength(160),

                    Forms\Components\TextInput::make('sort')
                        ->numeric()
                        ->label('Orden')
                        ->default(0)
                        ->helperText('0 aparece primero.'),

                    Forms\Components\Toggle::make('active')
                        ->label('Activo')
                        ->default(true)
                        ->helperText('Mantén máximo 4 activas.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Preview')->square(),
                Tables\Columns\TextColumn::make('title')->limit(30),
                Tables\Columns\TextColumn::make('alt')->label('Alt')->limit(30)->toggleable(),
                Tables\Columns\TextColumn::make('sort')->label('Orden')->sortable(),
                Tables\Columns\IconColumn::make('active')->boolean()->label('Activo'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')->label('Solo activas')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record, $action) {
                        // No pasa nada especial; si quieres, podrías impedir borrar si hay <=1 activa
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSliderImages::route('/'),
            'create' => Pages\CreateSliderImage::route('/create'),
            'edit'   => Pages\EditSliderImage::route('/{record}/edit'),
        ];
    }
}
