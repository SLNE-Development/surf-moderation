<?php

namespace App\Filament\Resources\Game\Punishment\BanResource\Pages;

use App\Filament\Resources\Game\Punishment\BanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBan extends EditRecord
{
    protected static string $resource = BanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
