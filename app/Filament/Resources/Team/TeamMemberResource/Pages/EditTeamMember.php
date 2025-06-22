<?php

namespace App\Filament\Resources\Team\TeamMemberResource\Pages;

use App\Filament\Resources\Team\TeamMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected static ?string $title = 'Teammitglied bearbeiten';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
