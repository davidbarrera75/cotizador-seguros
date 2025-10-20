<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifaImportLog extends Model
{
    protected $fillable = [
        'plan_id','user_id','filename',
        'processed','valid','imported','skipped','errors',
        'messages','status',
    ];

    protected $casts = [
        'processed' => 'int',
        'valid'     => 'int',
        'imported'  => 'int',
        'skipped'   => 'int',
        'errors'    => 'int',
        'messages'  => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
