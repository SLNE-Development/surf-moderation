<?php

namespace App\Filament\Resources\Team\TeamMemberResource\Pages;

use App\Filament\Resources\Team\TeamMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamMembers extends ListRecords
{
    protected static string $resource = TeamMemberResource::class;

    protected static ?string $title = 'Teammitglieder';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
