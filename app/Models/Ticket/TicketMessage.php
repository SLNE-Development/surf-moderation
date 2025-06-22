<?php

namespace App\Models\Ticket;

use App\Models\Game\GameUser;
use App\Models\Game\Utils\SocialConnection;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class TicketMessage extends Model
{
    use HasRelationships;

    protected $fillable = [
        'ticket_id',
        'author_id',
        'author_name',
        'author_avatar_url',
        'content',
        'references_message_id',
        'message_id',
        'bot_message',
        'message_created_at',
        'message_edited_at',
        'message_deleted_at',
    ];

    protected $casts = [
        'message_created_at' => 'datetime',
        'message_edited_at' => 'datetime',
        'message_deleted_at' => 'datetime',
        'bot_message' => 'boolean',
    ];

    protected $with = [
        'attachments',
        'author'
    ];

    public function getRouteKeyName()
    {
        return 'message_id';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketMessageAttachment::class, 'message_id', 'message_id');
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
                "author_id",
                "game_user_id"
            ]
        );
    }

}
