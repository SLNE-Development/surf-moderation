<?php

namespace App\Filament\Resources\Game\Punishment\BanResource\Pages;

use App\Filament\Resources\Game\Punishment\BanResource;
use Filament\Resources\Pages\ListRecords;

class ListBans extends ListRecords
{
    protected static string $resource = BanResource::class;
    protected static ?string $title = "Bans";

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
