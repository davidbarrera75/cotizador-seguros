<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoViaje extends Model
{
    use HasFactory;

    protected $table = 'tipo_viajes';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function planes()
    {
        return $this->belongsToMany(\App\Models\Plan::class, 'plan_tipo_viaje');
    }
    public function cotizacions()
{
    return $this->hasMany(\App\Models\Cotizacion::class, 'tipo_viaje_id');
}

}
