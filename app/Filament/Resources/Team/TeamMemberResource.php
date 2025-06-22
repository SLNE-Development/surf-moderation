<?php

namespace App\Filament\Resources\Team;

use App\Filament\Resources\Team\TeamMemberResource\Pages;
use App\Filament\Resources\Team\TeamMemberResource\RelationManagers;
use App\Models\Team\TeamMember;
use App\Models\Team\TeamMemberRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationGroup = "Team";
    protected static ?string $navigationIcon = 'fas-users';
    protected static ?string $navigationLabel = "Teammitglieder";
    protected static ?string $navigationBadgeTooltip = "Anzahl Teammitglieder";
    protected static ?int $navigationSort = 50;

    protected static ?string $label = "Teammitglied";
    protected static ?string $pluralLabel = "Teammitglieder";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Allgemein Informationen")->schema([
                    Forms\Components\TextInput::make("minecraft_uuid")
                        ->label("Minecraft Uuid")
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->length(36),
                    Forms\Components\TextInput::make("discord_id")
                        ->label("Discord Id")
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->minLength(12)
                        ->maxLength(19),

                    Forms\Components\TextInput::make("username")
                        ->label("Benutzername")
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(16),
                    Forms\Components\TextInput::make("team_email")
                        ->label("Team E-Mail")
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("private_email")
                        ->label("Privat E-Mail")
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->email()
                        ->maxLength(255),
                ]),

                Forms\Components\Section::make("Persönliche Informationen")->schema([
                    Forms\Components\TextInput::make("first_name")
                        ->label("Vorname")
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("address_state")
                        ->label("Bundesland")
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("job")
                        ->label("Job")
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make("birth_date")
                        ->label("Geburtsdatum")
                        ->nullable()
                        ->displayFormat("d.m.Y"),
                ]),

                Forms\Components\Section::make("Team Informationen")->schema([
                    Forms\Components\DatePicker::make("joined_at")
                        ->label("Beigetreten Am")
                        ->nullable()
                        ->displayFormat("d.m.Y"),
                    Forms\Components\DatePicker::make("exit_date")
                        ->label("Ausgetreten Am")
                        ->nullable()
                        ->displayFormat("d.m.Y"),
                ]),

                Forms\Components\Section::make("Panel Informationen")->schema([
                    Forms\Components\Select::make("user_id")
                        ->label("Panel User")
                        ->relationship("user", "name")
                        ->nullable()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make("name")
                                ->label("Name")
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make("email")
                                ->label("E-Mail")
                                ->required()
                                ->email()
                                ->maxLength(255),
                            Forms\Components\TextInput::make("password")
                                ->label("Passwort")
                                ->required()
                                ->password()
                                ->minLength(8)
                                ->maxLength(255),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("username")
                    ->label("Benutzername")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("activeRole.role")
                    ->label("Rolle")
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Aktive Teammitglieder')
                    ->query(fn(Builder $query): Builder => $query->active()),
                Tables\Filters\Filter::make('inactive')
                    ->label('Inaktive Teammitglieder')
                    ->query(fn(Builder $query): Builder => $query->inactive()),
                Tables\Filters\SelectFilter::make('active_role')
                    ->label('Rolle')
                    ->options(
                        TeamMemberRole::query()
                            ->distinct()
                            ->pluck('role', 'role')
                            ->mapWithKeys(fn($role) => [$role => ucfirst($role)])
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, $state) {
                        if (!$state || !$state["value"]) {
                            return;
                        }

                        $query->whereHas('activeRole', function (Builder $subQuery) use ($state) {
                            $subQuery->where('role', $state);
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
            RelationManagers\NotesRelationManager::class,
            RelationManagers\FeedbackRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'view' => Pages\ViewTeamMember::route('/{record}'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return TeamMember::query()->count();
    }
}
