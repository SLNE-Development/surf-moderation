<?php

namespace App\Models\Game\Punishment;

use App\Models\Game\GameUser;
use App\Models\Game\Punishment\Utils\BanIpAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $casts = [
        'expiration_date' => 'datetime',
        'permanent' => 'boolean',
        'securityBan' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return "punishment_id";
    }

    public function getExpirationAttribute(): string
    {
        if ($this->permanent || $this->securityBan) {
            return json_encode([
                'permanent' => true,
                'human_readable' => 'Permanent',
                'expires_at' => null,
                "expired" => false,
            ]);
        }

        if ($this->expiration_date?->isPast()) {
            return json_encode([
                'permanent' => false,
                'human_readable' => 'Abgelaufen',
                'expires_at' => $this->expiration_date,
                'expired' => true,
            ]);
        }

        return json_encode([
            'permanent' => false,
            'human_readable' => $this->expiration_date?->diffForHumans() ?? 'Unbekannt',
            'expires_at' => $this->expiration_date,
            'expired' => false,
        ]);
    }

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class, 'punished_uuid', 'uuid');
    }

    public function issuedBy()
    {
        return $this->belongsTo(GameUser::class, 'issuer_uuid', 'uuid');
    }

    public function ipAddresses()
    {
        return $this->hasMany(BanIpAddress::class, 'punishment_id', 'id');
    }

    public function parentBan()
    {
        return $this->belongsTo(Ban::class, 'parent_id', 'id');
    }

    public function childBans()
    {
        return $this->hasMany(Ban::class, 'parent_id', 'id');
    }
}
