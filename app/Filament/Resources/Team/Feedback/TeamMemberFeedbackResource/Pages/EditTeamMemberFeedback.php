<?php

namespace App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\Pages;

use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamMemberFeedback extends EditRecord
{
    protected static string $resource = TeamMemberFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
