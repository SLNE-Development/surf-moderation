<?php

namespace App\Filament\Resources\Game\Punishment\MuteResource\Pages;

use App\Filament\Resources\Game\Punishment\MuteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMutes extends ListRecords
{
    protected static string $resource = MuteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
