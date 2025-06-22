<?php

namespace App\Filament\Resources\Team\TeamMemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FeedbackRelationManager extends RelationManager
{
    protected static string $relationship = 'feedback';

    protected static ?string $title = 'Feedback';
    protected static ?string $label = 'Feedback';
    protected static ?string $pluralLabel = 'Feedbacks';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return is_subclass_of($pageClass, ViewRecord::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('due_at')
                    ->label('Fälligkeit')
                    ->seconds(false)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make("should_notify_supervisors")
                    ->label("Ansprechpartner benachrichtigen")
                    ->default(true)
                    ->helperText('Benachrichtigt die Ansprechpartner des Teammitglieds, wenn das Feedback abgeschlossen wird.')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make("due_at")
                    ->label('Fälligkeit')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('overdue')
                    ->label('Überfällig')
                    ->color(function ($state) {
                        return $state ? 'danger' : 'success';
                    })
                    ->boolean(),
                Tables\Columns\IconColumn::make("closed")
                    ->label("Abgeschlossen")
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->boolean(),
                Tables\Columns\TextColumn::make("closed_at")
                    ->label("Abgeschlossen am")
                    ->dateTime()
                    ->default(null),
                Tables\Columns\TextColumn::make("closedBy.name")
                    ->label("Abgeschlossen durch")
                    ->default(null),
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->url(fn(Model $record): string => route('filament.admin.resources.team.feedback.team-member-feedbacks.view', [
                        'record' => $record,
                    ])),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
