<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pais extends Model
{
    protected $table = 'pais';

    protected $fillable = ['codigo', 'nombre', 'region_id', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
