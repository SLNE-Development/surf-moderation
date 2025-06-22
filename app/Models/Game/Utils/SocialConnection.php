<?php

namespace App\Models\Game\Utils;

use App\Models\Game\GameUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SocialConnection extends Model
{
    protected $fillable = [
        "discord_id",
        "minecraft_uuid",
        "twitch_id"
    ];

    public function getDiscordUrlAttribute(): string
    {
        return "https://discord.com/users/$this->discord_id";
    }

    /**
     * @throws ConnectionException
     */
    public function getTwitchUrlAttribute(): string
    {
        $twitchLogin = $this->fetchTwitchUsername($this->twitch_id);

        return "https://twitch.tv/$twitchLogin";
    }

    /**
     * @throws ConnectionException
     */
    function fetchTwitchUsername(string $twitchId): ?string
    {
        $clientId = config('services.twitch.client_id');
        $clientSecret = config('services.twitch.client_secret');

        $authResponse = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        if (!$authResponse->ok()) {
            return null;
        }

        $accessToken = $authResponse['access_token'];

        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Client-Id' => $clientId,
        ])->get('https://api.twitch.tv/helix/users', [
            'id' => $twitchId,
        ]);

        if (!$userResponse->ok() || count($userResponse['data']) === 0) {
            return null;
        }

        return $userResponse['data'][0]['login'] ?? null;
    }

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class, 'game_user_id', 'id');
    }
}
