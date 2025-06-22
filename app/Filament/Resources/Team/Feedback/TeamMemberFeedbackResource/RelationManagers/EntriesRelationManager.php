<?php

namespace App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $title = 'Feedback Einträge';
    protected static ?string $label = 'Feedback Eintrag';
    protected static ?string $pluralLabel = 'Feedback Einträge';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return is_subclass_of($pageClass, ViewRecord::class);
    }

    protected function canCreate(): bool
    {
        return parent::canCreate() && !$this->ownerRecord->closed;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make("feedback_type")
                    ->label('Feedback Typ')
                    ->options([
                        "minecraft" => 'Minecraft',
                        "teamspeak" => 'TeamSpeak',
                        "discord" => 'Discord',
                        "ticket" => 'Ticket',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make("content")
                    ->label('Inhalt')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('feedback_type')
            ->columns([
                Tables\Columns\TextColumn::make('feedback_type')
                    ->label('Feedback Typ')
                    ->sortable(),
                Tables\Columns\TextColumn::make("author.name")
                    ->label('Autor')
                    ->sortable(),
                Tables\Columns\TextColumn::make("content")
                    ->words(50)
                    ->limit(100)
                    ->html()
                    ->label('Inhalt')
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->label('Erstellt am')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('author')
                    ->query(fn($query) => $query->whereRelation('author', 'id', auth()->id()))
                    ->label('Nur meine Einträge'),
                Tables\Filters\SelectFilter::make('feedback_type')
                    ->label('Feedback Typ')
                    ->options([
                        'minecraft' => 'Minecraft',
                        'teamspeak' => 'TeamSpeak',
                        'discord' => 'Discord',
                        'ticket' => 'Ticket',
                    ])
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data) {
                    $data['author_id'] = auth()->id();

                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
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
