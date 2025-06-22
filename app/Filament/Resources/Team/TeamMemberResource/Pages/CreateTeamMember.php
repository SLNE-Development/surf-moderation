<?php

namespace App\Filament\Resources\Team\TeamMemberResource\Pages;

use App\Filament\Resources\Team\TeamMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamMember extends CreateRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected static ?string $title = 'Teammitglied erstellen';
}
