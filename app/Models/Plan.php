<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int         $id
 * @property string      $nombre
 * @property int         $edad_maxima
 * @property bool        $activo
 * @property bool        $aplica_todos_paises_origen
 * @property bool        $aplica_todos_paises_destino
 * @property int|null    $aseguradora_id
 * @property float|null  $descuento          // % (0–100)
 * @property float|null  $rating             // 0–5 (pasos de 0.5)
 * @property string|null $cobertura          // HTML
 * @property string|null $cobertura_pdf_path // storage path
 */
class Plan extends Model
{
    /** Campos asignables en masa */
    protected $fillable = [
        'nombre',
        'edad_maxima',
        'activo',
        'aplica_todos_paises_origen',
        'aplica_todos_paises_destino',
        'aseguradora_id',
        'descuento',           // %
        'rating',              // 0–5
        'cobertura',           // HTML
        'cobertura_pdf_path',  // ruta del PDF
    ];

    /** Casts */
    protected $casts = [
        'activo'    => 'boolean',
        'aplica_todos_paises_origen' => 'boolean',
        'aplica_todos_paises_destino' => 'boolean',
        'edad_maxima' => 'integer',
        'descuento' => 'decimal:2',
        'rating'    => 'decimal:1',
    ];

    /* ==========================
     |  Relaciones
     * ========================== */

    /** @return BelongsToMany<Destino> */
    public function destinos(): BelongsToMany
    {
        return $this->belongsToMany(Destino::class, 'destino_plan');
    }

    /** @return BelongsToMany<TipoViaje> */
    public function tiposViaje(): BelongsToMany
    {
        return $this->belongsToMany(TipoViaje::class, 'plan_tipo_viaje');
    }

    /** @return BelongsToMany<Pais> */
    public function paisesOrigenExcluidos(): BelongsToMany
    {
        return $this->belongsToMany(Pais::class, 'plan_pais_origen_excluido', 'plan_id', 'pais_id');
    }

    /** @return BelongsToMany<Pais> */
    public function paisesDestinoExcluidos(): BelongsToMany
    {
        return $this->belongsToMany(Pais::class, 'plan_pais_destino_excluido', 'plan_id', 'pais_id');
    }

    /** @return HasMany<Tarifa> */
    public function tarifas(): HasMany
    {
        return $this->hasMany(Tarifa::class);
    }

    /** @return BelongsTo<Aseguradora, Plan> */
    public function aseguradora(): BelongsTo
    {
        return $this->belongsTo(Aseguradora::class);
    }

    /** @return HasMany<Order> */
    public function orders(): HasMany
    {
        // Ajusta la clase si tu modelo está en otro namespace
        return $this->hasMany(\App\Models\Order::class, 'plan_id');
    }

    /* ==========================
     |  Scopes / Helpers
     * ========================== */

    /** Scope rápido para activos */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /** ¿Tiene descuento configurado (>0)? */
    public function getTieneDescuentoAttribute(): bool
    {
        return (float) ($this->descuento ?? 0) > 0;
    }
}
