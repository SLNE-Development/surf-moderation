<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameUserNameHistory extends Model
{
    use HasFactory;

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class);
    }
}
