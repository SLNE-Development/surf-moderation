<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PunishmentTemplate extends Model
{
    protected $fillable = [
        'category',
        'name',
        'description',
        'punishment_type',
        'duration',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function getDurationFromNowAttribute()
    {
        return $this->duration > 0 ? now()->addSeconds($this->duration) : null;
    }
}
