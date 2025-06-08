<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages;

use App\Filament\Resources\Game\GameUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGameUser extends ViewRecord
{
    protected static string $resource = GameUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
