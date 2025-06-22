<?php

namespace App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\Pages;

use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamMemberFeedback extends CreateRecord
{
    protected static string $resource = TeamMemberFeedbackResource::class;
}
