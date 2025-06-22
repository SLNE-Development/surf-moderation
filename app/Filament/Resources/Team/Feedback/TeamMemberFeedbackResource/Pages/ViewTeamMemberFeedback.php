<?php

namespace App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\Pages;

use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource;
use App\Models\Team\Feedback\TeamMemberFeedback;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewTeamMemberFeedback extends ViewRecord
{
    protected static string $resource = TeamMemberFeedbackResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make("Informationen")->schema([
                TextEntry::make("due_at")
                    ->label('Fälligkeit')
                    ->dateTime(),
                IconEntry::make('overdue')
                    ->label('Überfällig')
                    ->color(fn($state) => $state ? 'danger' : 'success')
                    ->boolean(),
                IconEntry::make("should_notify_supervisors")
                    ->label("Vorgesetzte benachrichtigen")
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->boolean(),
            ]),
            Section::make("Geschlossen")->schema([
                IconEntry::make("closed")
                    ->label("Abgeschlossen")
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->boolean(),
                TextEntry::make("closed_at")
                    ->label("Abgeschlossen am")
                    ->dateTime()
                    ->default(null),
                TextEntry::make("closedBy.name")
                    ->label("Abgeschlossen durch")
                    ->default(null),
            ]),
            Section::make("Inhalt")->schema([
                TextEntry::make("content")
                    ->label("")
                    ->html()
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make("close")
                ->visible(fn(TeamMemberFeedback $record): bool => !$record->closed)
                ->label("Abschließen")
                ->color("warning")
                ->icon("fas-times")
                ->modalHeading("Feedback abschließen")
                ->steps([
                    Step::make("Informationen")
                        ->description("Allgemeine Informationen über das Feedback")
                        ->schema([
                            Toggle::make("should_notify_supervisors")
                                ->label("Vorgesetzte benachrichtigen")
                                ->helperText("Benachrichtige die Vorgesetzten des Teammitglieds über dieses Feedback.")
                                ->columnSpanFull()
                                ->default(true),
                            DateTimePicker::make("closed_at")
                                ->label("Abschlussdatum")
                                ->required()
                                ->seconds(false)
                                ->default(now())
                                ->columnSpanFull(),
                        ]),
                    Step::make("Inhalt")
                        ->description("Inhalt des Feedbacks")
                        ->schema([
                            RichEditor::make("content")
                                ->label("Inhalt")
                                ->required()
                                ->columnSpanFull(),
                        ]),
                ])->action(function (array $data, TeamMemberFeedback $record) {
                    $record->closedBy()->associate(auth()->user());
                    $record->closed_at = $data['closed_at'];
                    $record->content = $data['content'];
                    $record->should_notify_supervisors = $data['should_notify_supervisors'] ?? false;

                    $record->save();
                }),
            EditAction::make()->visible(fn(TeamMemberFeedback $record): bool => !$record->closed)
        ];
    }
}
