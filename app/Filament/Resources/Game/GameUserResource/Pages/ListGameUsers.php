<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages;

use App\Filament\Resources\Game\GameUserResource;
use Filament\Resources\Pages\ListRecords;

class ListGameUsers extends ListRecords
{
    protected static string $resource = GameUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
