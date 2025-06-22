<?php

namespace App\Filament\Resources\Team\TeamMemberResource\Pages;

use App\Filament\Resources\Team\TeamMemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTeamMember extends ViewRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected static ?string $title = 'Teammitglied ansehen';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            TeamMemberResource\Widgets\Team\WeeklyFeedbackWidget::make([
                "teamMember" => $this->getRecord()
            ])
        ];
    }
}
