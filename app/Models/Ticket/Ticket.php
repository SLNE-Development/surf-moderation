<?php

namespace App\Models\Ticket;

use App\Models\Game\GameUser;
use App\Models\Game\Utils\SocialConnection;
use App\Models\Team\TeamMember;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Ticket extends Model
{
    use HasRelationships;

    protected $fillable = [
        'ticket_id',
        'ticket_author_id',
        'ticket_author_name',
        'ticket_author_avatar_url',
        'guild_id',
        'thread_id',
        'ticket_type',
        'opened_at',
        'closed_by_id',
        'closed_by_name',
        'closed_by_avatar_url',
        'closed_at',
        'closed_reason'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'ticket_id';
    }

    public function getTicketTypeLabelAttribute()
    {
        return match ($this->ticket_type) {
            'survival_support' => 'Survival Support',
            'event_support' => 'Event Support',
            'discord_support' => 'Discord Support',
            'bugreport' => 'Bug Report',
            'whitelist' => 'Whitelist',
            'report' => 'Report',
            'unban' => 'Unban Request',
            default => 'Unknown Type',
        };
    }

    public function author()
    {
        return $this->hasOneDeep(
            GameUser::class,
            [SocialConnection::class],
            [
                "discord_id",
                "id"
            ],
            [
                "ticket_author_id",
                "game_user_id"
            ]
        );
    }

    protected $with = [
        'author',
        'messages',
    ];

    public function closedBy()
    {
        return $this->belongsTo(TeamMember::class, 'closed_by_id', 'discord_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id', 'id');
    }
}
