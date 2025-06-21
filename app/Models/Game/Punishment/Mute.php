<?php

namespace App\Models\Game\Punishment;

use App\Models\Game\GameUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mute extends Model
{
    use HasFactory;

    protected $casts = [
        'expiration_date' => 'datetime',
        'permanent' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return "punishment_id";
    }

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class, 'punished_uuid', 'uuid');
    }

    public function issuedBy()
    {
        return $this->belongsTo(GameUser::class, 'issuer_uuid', 'uuid');
    }
}
