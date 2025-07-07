<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    public function destinos()
    {
        return $this->belongsToMany(Destino::class, 'destino_plan');
    }

    public function tiposViaje()
    {
        return $this->belongsToMany(TipoViaje::class, 'plan_tipo_viaje');
    }
    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }
    public function aseguradora()
    {
        return $this->belongsTo(Aseguradora::class);
    }

    protected $fillable = [
        'nombre',
        'edad_maxima',
        'activo',
        'aseguradora_id',
    ];
}
