<?php

namespace App\Filament\Resources\Panel\NotificationResource\Pages;

use App\Filament\Resources\Panel\NotificationResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class CreateNotification extends CreateRecord
{
    protected static ?string $title = 'Benachrichtigung erstellen';
    protected static string $resource = NotificationResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl("index");
    }

    protected function handleRecordCreation(array $data): Model
    {
        $recipients = $data['recipients'];
        $title = $data['title'];
        $body = $data['data'];
        $status = $data['status'];
        $color = match ($status) {
            'info' => 'info',
            'success' => 'success',
            'warning' => 'warning',
            'danger' => 'danger',
            default => 'primary',
        };

        foreach ($recipients as $entry) {
            [$type, $id] = explode(':', $entry);

            if ($type === 'user') {
                $user = User::find($id);

                if ($user) {
                    Notification::make()
                        ->title($title)
                        ->body($body)
                        ->status($status)
                        ->color($color)
                        ->sendToDatabase($user, isEventDispatched: true);
                }
            }

//            if ($type === 'role') {
//                $role = Role::find($id);
//                if ($role) {
//                    foreach ($role->users as $user) {
//                        $user->notify(new DatabaseGenericNotification($notificationData));
//                    }
//                }
//            }
        }

        return new DatabaseNotification();
    }
}
