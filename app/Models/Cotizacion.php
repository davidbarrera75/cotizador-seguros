<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    // Ajusta según tus columnas reales
    protected $fillable = [
        'destino_id',
        'tipo_viaje_id',
        'pais_origen',
        'origen',
        'fecha_salida',
        'fecha_regreso',
        'correo_contacto',
        'telefono_contacto',
    ];

    /** Relación: una cotización tiene muchos pasajeros */
    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class);
    }

    /** Relación: pertenece a un destino (FK: destino_id) */
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    /** Relación: pertenece a un tipo de viaje (FK: tipo_viaje_id) */
    public function tipoViaje()
    {
        return $this->belongsTo(TipoViaje::class, 'tipo_viaje_id');
    }
}
