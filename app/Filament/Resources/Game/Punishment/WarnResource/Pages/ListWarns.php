<?php

namespace App\Filament\Resources\Game\Punishment\WarnResource\Pages;

use App\Filament\Resources\Game\Punishment\WarnResource;
use Filament\Resources\Pages\ListRecords;

class ListWarns extends ListRecords
{
    protected static string $resource = WarnResource::class;
    protected static ?string $title = "Verwarnungen";

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
