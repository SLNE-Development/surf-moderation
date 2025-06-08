<?php

namespace App\Filament\Resources\Game\Punishment\KickResource\Pages;

use App\Filament\Resources\Game\Punishment\KickResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKick extends EditRecord
{
    protected static string $resource = KickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
