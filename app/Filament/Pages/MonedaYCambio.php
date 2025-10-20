<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class MonedaYCambio extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-m-banknotes';
    protected static ?string $navigationLabel = 'Moneda y cambio';
    protected static ?string $title           = 'Moneda y cambio';
    protected static ?string $navigationGroup = 'Configuración';
    protected static string $view = 'filament.pages.moneda-y-cambio';

    public ?float  $usd_cop_rate   = null;
    public ?string $admin_whatsapp = null;

    public array $data = [];

    public function mount(): void
    {
        $this->usd_cop_rate   = AppSetting::usdCop();
        $this->admin_whatsapp = AppSetting::adminWhatsapp();
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()->schema([
                Forms\Components\TextInput::make('usd_cop_rate')
                    ->label('Valor del dólar (1 USD en COP)')
                    ->numeric()->step('0.0001')->minValue(1)->required(),

                Forms\Components\TextInput::make('admin_whatsapp')
                    ->label('WhatsApp del administrador (formato internacional sin +)')
                    ->helperText('Ejemplo Colombia: 573001234567')
                    ->maxLength(32),
            ])->statePath('data'),
        ];
    }

    public function save(): void
    {
        $rate  = (float) ($this->data['usd_cop_rate'] ?? $this->usd_cop_rate);
        $phone = $this->data['admin_whatsapp'] ?? $this->admin_whatsapp;

        if ($rate <= 0) {
            Notification::make()->title('Ingresa un valor de dólar válido')->danger()->send();
            return;
        }

        AppSetting::setRatesAndPhone($rate, $phone);
        $this->usd_cop_rate   = $rate;
        $this->admin_whatsapp = $phone;

        Notification::make()->title('Guardado')->success()->send();
    }
}
