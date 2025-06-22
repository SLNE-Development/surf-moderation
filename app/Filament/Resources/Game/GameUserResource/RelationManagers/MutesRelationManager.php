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
use Illuminate\Support\Carbon;

class MutesRelationManager extends RelationManager
{
    protected static string $relationship = 'mutes';

    protected static ?string $title = "Mutes";
    protected static ?string $label = "Mute";
    protected static ?string $pluralLabel = "Mutes";

    public function isReadOnly(): bool
    {
        return false;
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

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return is_subclass_of($pageClass, ViewRecord::class);
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
                Tables\Columns\TextColumn::make("expiration")
                    ->label("Ablauf")
                    ->tooltip(function ($state) {
                        $state = json_decode($state, true);
                        $expiresAt = $state["expires_at"] ?? null;
                        $expiresAt = $expiresAt ? Carbon::parse($expiresAt) : null;

                        return $expiresAt?->format(Table::$defaultDateTimeDisplayFormat);

                    })
                    ->formatStateUsing(function ($state) {
                        $state = json_decode($state, true);

                        return $state['human_readable'] ?? 'Unbekannt';
                    })
                    ->badge(function ($state) {
                        $state = json_decode($state, true);
                        $permanent = $state["permanent"];
                        $expired = $state["expired"] ?? false;
                        $humanReadable = $state['human_readable'] ?? 'Unbekannt';

                        if ($permanent || $expired) {
                            return $humanReadable;
                        }

                        return null;
                    })
                    ->color(function (string $state) {
                        $state = json_decode($state, true);
                        $expired = $state['expired'] ?? false;
                        $permanent = $state["permanent"] ?? false;

                        if ($permanent) {
                            return 'success';
                        }

                        return $expired ? 'danger' : null;
                    })
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
                    ->modalHeading("Mute erstellen")
                    ->createAnother(false)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data["punishment_id"] = PunishmentIdGenerator::generate();
                        $data["issuer_uuid"] = "5c63e51b-82b1-4222-af0f-66a4c31e36ad";
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->url(fn(Model $record): string => route('filament.admin.resources.game.punishment.mutes.view', [
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
