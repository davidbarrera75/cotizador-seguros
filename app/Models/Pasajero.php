<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    protected $fillable = [
        'cotizacion_id',
        'edad',
        'direccion',
        'pais',
    ];
}
