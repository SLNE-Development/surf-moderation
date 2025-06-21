<?php

namespace App\Models\Game\Punishment\Utils;

use App\Models\Game\Punishment\Ban;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanIpAddress extends Model
{
    use HasFactory;

    public function ban()
    {
        return $this->belongsTo(Ban::class, 'punishment_id', 'id');
    }
}
