<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasajero extends Model
{
    protected $fillable = [
        'cotizacion_id',
        'edad',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'tipo_documento',
        'numero_documento',
        'direccion',
        'pais',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'contacto_emergencia_email',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(\App\Models\Cotizacion::class, 'cotizacion_id');
    }
}