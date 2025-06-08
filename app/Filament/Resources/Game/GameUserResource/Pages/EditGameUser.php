<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages;

use App\Filament\Resources\Game\GameUserResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditGameUser extends EditRecord
{
    protected static string $resource = GameUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title("Benutzer erfolgreich aktualisiert")
            ->body("Die Änderungen am Benutzerprofil wurden erfolgreich gespeichert.")
            ->actions([
                Action::make('view')
                    ->button()
                    ->markAsRead(),
            ])
            ->success()
            ->icon('heroicon-o-check-circle')
            ->sendToDatabase(auth()->user(), true);
    }
}
