<?php

namespace App\Utils\Notification;

use Illuminate\Notifications\Notification;

class DatabaseGenericNotification extends Notification
{
    public function __construct(protected string $data)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return ["data" => $this->data];
    }
}
