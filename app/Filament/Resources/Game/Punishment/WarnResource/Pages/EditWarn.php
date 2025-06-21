<?php

namespace App\Filament\Resources\Game\Punishment\WarnResource\Pages;

use App\Filament\Resources\Game\Punishment\WarnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarn extends EditRecord
{
    protected static string $resource = WarnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
