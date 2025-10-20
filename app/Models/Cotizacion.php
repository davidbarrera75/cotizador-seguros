<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'destino_id',
        'region_id',
        'destino_pais_id',
        'origen_pais_id',
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

    /** Relación: pertenece a un destino (FK: destino_id) - LEGACY */
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    /** Relación: pertenece a una región */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /** Relación: país de destino */
    public function destinoPais()
    {
        return $this->belongsTo(Pais::class, 'destino_pais_id');
    }

    /** Relación: país de origen */
    public function origenPais()
    {
        return $this->belongsTo(Pais::class, 'origen_pais_id');
    }

    /** Relación: pertenece a un tipo de viaje (FK: tipo_viaje_id) */
    public function tipoViaje()
    {
        return $this->belongsTo(TipoViaje::class, 'tipo_viaje_id');
    }
}
