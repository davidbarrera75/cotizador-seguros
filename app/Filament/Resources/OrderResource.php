<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\AppSetting;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon  = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Órdenes';
    protected static ?string $pluralModelLabel = 'Órdenes';
    protected static ?string $modelLabel = 'Orden';
    protected static ?string $navigationGroup = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Datos de la orden')->schema([
                    Forms\Components\TextInput::make('id')->disabled()->dehydrated(false),
                    Forms\Components\Select::make('estado')
                        ->options([
                            'creada'      => 'Creada',
                            'enviada_wa'  => 'Enviada a WhatsApp',
                            'pagada'      => 'Pagada',
                            'cancelada'   => 'Cancelada',
                        ])->required(),
                    Forms\Components\TextInput::make('moneda')->maxLength(3)->disabled(),
                    Forms\Components\TextInput::make('precio')->numeric()->disabled(),
                    Forms\Components\TextInput::make('tasa_usd_cop')->numeric()->step('0.0001')->disabled(),
                    Forms\Components\TextInput::make('admin_whatsapp')->label('WhatsApp admin')->helperText('Formato internacional sin + (ej. 573001234567)'),
                ])->columns(2),

                Forms\Components\Section::make('Cliente')->schema([
                    Forms\Components\TextInput::make('cliente_nombre'),
                    Forms\Components\TextInput::make('cliente_email'),
                    Forms\Components\TextInput::make('cliente_telefono'),
                ])->columns(3),

                Forms\Components\Section::make('Viaje')->schema([
                    Forms\Components\TextInput::make('destino')->disabled(),
                    Forms\Components\TextInput::make('tipo_viaje')->disabled(),
                    Forms\Components\DatePicker::make('fecha_salida')->disabled(),
                    Forms\Components\DatePicker::make('fecha_regreso')->disabled(),
                    Forms\Components\TextInput::make('pasajeros_count')->numeric()->disabled(),
                ])->columns(3),

                Forms\Components\Section::make('Mensaje de WhatsApp')->schema([
                    Forms\Components\Textarea::make('whatsapp_message')->rows(6),
                ]),
            ])->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime('Y-m-d H:i')->sortable(),
                Tables\Columns\TextColumn::make('cliente_nombre')
                    ->label('Cliente')->searchable(),
                Tables\Columns\TextColumn::make('cliente_email')
                    ->label('Email')->toggleable(isToggledHiddenByDefault: true)->searchable(),
                Tables\Columns\TextColumn::make('plan.nombre')
                    ->label('Plan')->limit(30)->searchable(),
                Tables\Columns\TextColumn::make('aseguradora.nombre')
                    ->label('Aseguradora')->limit(20)->sortable(),
                Tables\Columns\BadgeColumn::make('moneda')
                    ->colors(['primary'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('precio')
                    ->label('Precio')
                    ->formatStateUsing(fn ($state, Order $r) => $r->moneda === 'USD'
                        ? 'US$'.number_format((float)$state, 2)
                        : '$'.number_format((float)$state, 0)
                    )
                    ->alignEnd()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('estado')
                    ->colors([
                        'warning' => 'creada',
                        'info'    => 'enviada_wa',
                        'success' => 'pagada',
                        'danger'  => 'cancelada',
                    ])
                    ->formatStateUsing(fn($state, $record) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->options([
                        'creada' => 'Creada',
                        'enviada_wa' => 'Enviada a WhatsApp',
                        'pagada' => 'Pagada',
                        'cancelada' => 'Cancelada',
                    ]),
                SelectFilter::make('moneda')
                    ->options(['COP' => 'COP', 'USD' => 'USD']),
                Filter::make('created_at')
                    ->label('Fecha de creación')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Desde'),
                        Forms\Components\DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['until'] ?? null, fn ($q, $d) => $q->whereDate('created_at', '<=', $d));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->url(function (Order $record): ?string {
                        $phone = $record->admin_whatsapp
                            ?: (AppSetting::adminWhatsapp() ?: config('services.admin_whatsapp'));
                        $digits = preg_replace('/\D+/', '', (string) $phone);
                        if (!$digits) return null;

                        $msg = $record->whatsapp_message ?: static::buildMessageFromOrder($record);
                        return 'https://wa.me/'.$digits.'?text='.urlencode($msg);
                    }, shouldOpenInNewTab: true)
                    ->color('success'),

                Tables\Actions\Action::make('copiar')
                    ->label('Copiar mensaje')
                    ->icon('heroicon-m-clipboard')
                    ->tooltip('Copiar al portapapeles')
                    ->extraAttributes(fn (Order $record) => [
                        'x-data'     => '{}',
                        'x-on:click' => 'navigator.clipboard.writeText('
                            . json_encode($record->whatsapp_message ?: static::buildMessageFromOrder($record))
                            . ').then(() => { /* opcional: alert("Mensaje copiado"); */ });',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('marcar_enviada_wa')
                        ->label('Marcar como enviada a WhatsApp')
                        ->icon('heroicon-m-paper-airplane')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update([
                            'estado' => 'enviada_wa',
                            'sent_to_whatsapp_at' => now(),
                        ])),
                ]),
            ]);
    }

    /** Construir mensaje si no existe en la orden */
    public static function buildMessageFromOrder(Order $o): string
    {
        $simbolo = $o->moneda === 'USD' ? 'US$' : '$';
        $dec     = $o->moneda === 'USD' ? 2 : 0;
        $precio  = $o->precio !== null ? ($simbolo.number_format((float)$o->precio, $dec)) : 'N/D';

        return "Hola, soy {$o->cliente_nombre}. Quiero confirmar la compra del paquete:\n"
            . "• Cotización #{$o->cotizacion_id}\n"
            . "• Plan: ".($o->plan?->nombre ?? 'Plan no especificado')
            . ($o->aseguradora?->nombre ? " ({$o->aseguradora->nombre})" : "")
            . "\n• Destino: {$o->destino}\n"
            . "• Tipo de viaje: {$o->tipo_viaje}\n"
            . "• Fechas: {$o->fecha_salida} → {$o->fecha_regreso}\n"
            . "• Pasajeros: {$o->pasajeros_count}\n"
            . "• Precio: {$precio}\n"
            . "Datos de contacto: {$o->cliente_email}"
            . ($o->cliente_telefono ? " / {$o->cliente_telefono}" : "");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}