<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketMessageAttachment extends Model
{
    protected $fillable = [
        "attachment_id",
        "filename",
        "url",
        "proxy_url",
        "waveform",
        "content_type",
        "description",
        "size",
        "height",
        "width",
        "ephemeral",
        "duration_secs",
        "message_id",
    ];

    protected $casts = [
        'size' => 'integer',
        'height' => 'integer',
        'width' => 'integer',
        'ephemeral' => 'boolean',
        'duration_secs' => 'float',
    ];

    public function getRouteKeyName()
    {
        return 'attachment_id';
    }

    public function ticketMessage()
    {
        return $this->belongsTo(TicketMessage::class, 'ticket_message_id', 'id');
    }
}
