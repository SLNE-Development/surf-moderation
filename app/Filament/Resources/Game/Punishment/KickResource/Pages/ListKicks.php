<?php

namespace App\Filament\Resources\Game\Punishment\KickResource\Pages;

use App\Filament\Resources\Game\Punishment\KickResource;
use Filament\Resources\Pages\ListRecords;

class ListKicks extends ListRecords
{
    protected static string $resource = KickResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
