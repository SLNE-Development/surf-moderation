<?php

namespace App\Models\Game\Utils;

use App\Models\Game\GameUser;
use Illuminate\Database\Eloquent\Model;

class Whitelist extends Model
{
    protected $fillable = [
        'uuid',
        'server',
        'blocked',
    ];

    protected $casts = [
        'blocked' => 'boolean',
    ];

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class, 'game_user_id');
    }
}
