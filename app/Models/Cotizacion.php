<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $fillable = [
        'destino_id',
        'tipo_viaje_id',
        'origen',
        'fecha_salida',
        'fecha_regreso',
        'correo_contacto',
        'telefono_contacto',
    ];
    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class);
    }
}
