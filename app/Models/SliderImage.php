<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    protected $fillable = ['title', 'image_path', 'active', 'sort'];

    // Scope: solo activas
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Accessor: devuelve URL pública
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}