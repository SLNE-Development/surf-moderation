<?php

namespace App\Filament\Resources\Game\Punishment\MuteResource\Pages;

use App\Filament\Resources\Game\Punishment\MuteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMute extends EditRecord
{
    protected static string $resource = MuteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
