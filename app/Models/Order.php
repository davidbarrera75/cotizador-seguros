<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cotizacion_id','plan_id','aseguradora_id','estado','moneda','precio','tasa_usd_cop',
        'admin_whatsapp','cliente_nombre','cliente_email','cliente_telefono','destino','tipo_viaje',
        'fecha_salida','fecha_regreso','pasajeros_count','pasajeros_payload','whatsapp_message',
        'sent_to_whatsapp_at',
    ];

    protected $casts = [
        'pasajeros_payload'   => 'array',
        'sent_to_whatsapp_at' => 'datetime',
        'fecha_salida'        => 'date',
        'fecha_regreso'       => 'date',
        'precio'              => 'decimal:2',
        'tasa_usd_cop'        => 'decimal:4',
    ];

    public function cotizacion()  { return $this->belongsTo(Cotizacion::class); }
    public function plan()        { return $this->belongsTo(Plan::class); }
    public function aseguradora() { return $this->belongsTo(Aseguradora::class); }
}
