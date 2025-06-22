<?php

namespace App\Models\Game;

use App\Models\Game\Punishment\Ban;
use App\Models\Game\Punishment\Kick;
use App\Models\Game\Punishment\Mute;
use App\Models\Game\Punishment\Warn;
use App\Models\Game\Utils\Whitelist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{

    use HasFactory;

    public function getUsernameWithFallbackAttribute()
    {
        return $this->last_name ?: $this->uuid;
    }

    public function getHasFreebuildWhitelistAttribute()
    {
        return $this->whitelists()->where('server', 'freebuild')->exists();
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function nameHistories()
    {
        return $this->hasMany(GameUserNameHistory::class);
    }

    public function issuedBans()
    {
        return $this->hasMany(Ban::class, "issuer_uuid", "uuid");
    }

    public function issuedKicks()
    {
        return $this->hasMany(Kick::class, "issuer_uuid", "uuid");
    }

    public function issuedMutes()
    {
        return $this->hasMany(Mute::class, "issuer_uuid", "uuid");
    }

    public function issuedWarns()
    {
        return $this->hasMany(Warn::class, "issuer_uuid", "uuid");
    }

    public function bans()
    {
        return $this->hasMany(Ban::class, "punished_uuid", "uuid");
    }

    public function kicks()
    {
        return $this->hasMany(Kick::class, "punished_uuid", "uuid");
    }

    public function mutes()
    {
        return $this->hasMany(Mute::class, "punished_uuid", "uuid");
    }

    public function warns()
    {
        return $this->hasMany(Warn::class, "punished_uuid", "uuid");
    }

    public function whitelists()
    {
        return $this->hasMany(Whitelist::class, 'game_user_id');
    }
}
