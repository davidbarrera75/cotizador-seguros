<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = ['usd_cop_rate','admin_whatsapp'];

    protected $casts = [
        'usd_cop_rate' => 'float',
    ];

    public static function current(): self
    {
        return static::query()->first() ?? static::create(['usd_cop_rate' => 4000.0]);
    }

    public static function usdCop(): float
    {
        return static::current()->usd_cop_rate ?: 4000.0;
    }

    public static function adminWhatsapp(): ?string
    {
        return static::current()->admin_whatsapp;
    }

    public static function setRatesAndPhone(float $rate, ?string $phone): void
    {
        $s = static::current();
        $s->usd_cop_rate   = $rate;
        $s->admin_whatsapp = $phone;
        $s->save();

        try { cache()->tags(['cotizador'])->flush(); } catch (\Throwable $e) {}
    }
}
