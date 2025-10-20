<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Plans';
    protected static ?string $pluralModelLabel = 'Planes';
    protected static ?string $modelLabel = 'Plan';

    public static function form(Form $form): Form
{
    return $form->schema([
        Select::make('aseguradora_id')
            ->relationship('aseguradora', 'nombre')
            ->label('Aseguradora')
            ->required()
            ->preload(),

        TextInput::make('nombre')->required(),

        TextInput::make('edad_maxima')
            ->numeric()->required()->label('Edad máxima'),

        TextInput::make('descuento')
            ->label('Descuento (%)')
            ->numeric()->minValue(0)->maxValue(100)->step('0.01')->default(0)
            ->helperText('Porcentaje de descuento aplicado al precio del plan.'),

        // ⭐️ Nuevo: Rating
        TextInput::make('rating')
            ->label('Rating (0–5)')
            ->numeric()->minValue(0)->maxValue(5)->step('0.5')
            ->helperText('Calificación que verán los usuarios (estrellas).'),

        Toggle::make('activo')->default(true),

        // ⭐️ NUEVO: País de Origen
        Forms\Components\Section::make('Países de Origen')
            ->schema([
                Toggle::make('aplica_todos_paises_origen')
                    ->label('Aplica para todos los países de origen')
                    ->default(true)
                    ->reactive()
                    ->helperText('Si está activado, el plan aplica para todos los países de origen excepto los excluidos.'),

                Select::make('paisesOrigenExcluidos')
                    ->label('Excluir países de origen')
                    ->multiple()
                    ->relationship(name: 'paisesOrigenExcluidos', titleAttribute: 'nombre')
                    ->preload()
                    ->searchable()
                    ->visible(fn (callable $get) => $get('aplica_todos_paises_origen') === true)
                    ->helperText('Seleccione los países de origen que desea excluir de este plan.'),
            ])
            ->collapsible(),

        // ⭐️ NUEVO: País de Destino
        Forms\Components\Section::make('Países de Destino')
            ->schema([
                Toggle::make('aplica_todos_paises_destino')
                    ->label('Aplica para todos los países de destino')
                    ->default(true)
                    ->reactive()
                    ->helperText('Si está activado, el plan aplica para todos los países de destino excepto los excluidos.'),

                Select::make('paisesDestinoExcluidos')
                    ->label('Excluir países de destino')
                    ->multiple()
                    ->relationship(name: 'paisesDestinoExcluidos', titleAttribute: 'nombre')
                    ->preload()
                    ->searchable()
                    ->visible(fn (callable $get) => $get('aplica_todos_paises_destino') === true)
                    ->helperText('Seleccione los países de destino que desea excluir de este plan.'),
            ])
            ->collapsible(),

        Select::make('destinos')
            ->multiple()
            ->relationship(name: 'destinos', titleAttribute: 'nombre')->preload(),

        Select::make('tiposViaje')
            ->multiple()
            ->relationship(name: 'tiposViaje', titleAttribute: 'nombre')->preload(),

        // Cobertura (texto)
        Forms\Components\RichEditor::make('cobertura')
            ->label('Cobertura (HTML)')
            ->toolbarButtons([
                'bold','italic','underline','strike','link','orderedList','unorderedList','blockquote','codeBlock',
            ])
            ->columnSpan('full'),

        // Cobertura (PDF)
        Forms\Components\FileUpload::make('cobertura_pdf_path')
            ->label('PDF de Cobertura')
            ->directory('planes/coberturas')
            ->acceptedFileTypes(['application/pdf'])
            ->openable()
            ->downloadable()
            ->helperText('Sube un PDF con el detalle de la cobertura.'),

        Repeater::make('tarifas')
            ->relationship()
            ->schema([
                TextInput::make('dias')->numeric()->required()->label('Días'),
                TextInput::make('precio')->numeric()->prefix('$')->required()->label('Precio'),
            ])
            ->columns(2)
            ->label('Tarifas'),
    ]);
}


    public static function table(Table $table): Table
    {
        return $table
            // Traemos conteo de órdenes para decidir visibilidad del botón Eliminar
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('orders'))
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->label('Nombre'),

                TextColumn::make('aseguradora.nombre')
                    ->label('Aseguradora')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('edad_maxima')
                    ->label('Edad máxima')
                    ->sortable(),

                // 💡 FIX: usar ($state) o tipado, no ($s)
                TextColumn::make('descuento')
                    ->label('Desc. %')
                    ->formatStateUsing(fn (mixed $state): string => number_format((float)($state ?? 0), 2) . '%')
                    ->sortable(),

                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // Mostrar "Eliminar" solo si NO tiene órdenes asociadas
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->visible(fn ($record) => (int)($record->orders_count ?? 0) === 0),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // DeleteBulkAction desactivada para evitar borrar en lote con relaciones
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
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
