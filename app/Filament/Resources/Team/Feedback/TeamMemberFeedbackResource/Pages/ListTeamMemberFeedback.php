<?php

namespace App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\Pages;

use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamMemberFeedback extends ListRecords
{
    protected static string $resource = TeamMemberFeedbackResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
