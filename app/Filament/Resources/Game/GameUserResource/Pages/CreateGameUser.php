<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages;

use App\Filament\Resources\Game\GameUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGameUser extends CreateRecord
{
    protected static string $resource = GameUserResource::class;
}
