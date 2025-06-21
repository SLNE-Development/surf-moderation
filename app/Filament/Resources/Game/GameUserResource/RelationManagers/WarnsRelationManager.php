<?php

namespace App\Filament\Resources\Game\GameUserResource\RelationManagers;

use App\Utils\PunishmentIdGenerator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class WarnsRelationManager extends RelationManager
{
    protected static ?string $title = "Verwarnungen";
    protected static string $relationship = 'warns';

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
                Forms\Components\TextInput::make("reason")
                    ->label("Grund")
                    ->minLength(3)
                    ->required()
            ]);
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort("created_at", "desc")
            ->recordTitleAttribute('punishment_id')
            ->columns([
                Tables\Columns\TextColumn::make("punishment_id")
                    ->label("Id")
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Grund')
                    ->searchable(),
                Tables\Columns\TextColumn::make("issuedBy.username_with_fallback")
                    ->label("Ausgeführt durch")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->label("Erstellt am")
                    ->sortable()
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading("Verwarnung erstellen")
                    ->createAnother(false)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data["punishment_id"] = PunishmentIdGenerator::generate();
                        $data["issuer_uuid"] = "5c63e51b-82b1-4222-af0f-66a4c31e36ad";
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->url(fn(Model $record): string => route('filament.admin.resources.game.punishment.warns.view', [
                        'record' => $record,
                    ])),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->label("Aktionen")
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
