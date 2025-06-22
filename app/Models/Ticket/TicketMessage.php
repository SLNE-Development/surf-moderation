<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
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

    public function getRouteKeyName()
    {
        return 'message_id';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
