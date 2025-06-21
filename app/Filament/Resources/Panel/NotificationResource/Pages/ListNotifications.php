<?php

namespace App\Filament\Resources\Panel\NotificationResource\Pages;

use App\Filament\Resources\Panel\NotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotifications extends ListRecords
{
    protected static ?string $title = 'Benachrichtigungen';
    protected static string $resource = NotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
