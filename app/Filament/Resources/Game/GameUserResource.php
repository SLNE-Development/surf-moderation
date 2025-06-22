<?php

namespace App\Filament\Resources\Game;

use App\Filament\Resources\Game\GameUserResource\Pages;
use App\Filament\Resources\Game\GameUserResource\RelationManagers;
use App\Models\Game\GameUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class GameUserResource extends Resource
{
    protected static ?string $model = GameUser::class;

    protected static ?string $breadcrumb = 'Benutzerverwaltung';
    protected static ?string $navigationLabel = 'Benutzerverwaltung';
    protected static ?string $navigationIcon = 'fas-people-group';

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->last_name . ' (' . $record->uuid . ')';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['last_name', 'uuid', "nameHistories.username"];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make()
                    ->columns(12)
                    ->schema([
                        Section::make('Informationen')
                            ->description("Allgemeine Informationen über den Benutzer")
                            ->columns(2)
                            ->schema([
                                TextEntry::make('uuid')->label('UUID'),
                                TextEntry::make('last_name')->label('Benutzername'),

                                IconEntry::make("has_freebuild_whitelist")
                                    ->label("Freebuild Whitelist")
                                    ->icon(fn(GameUser $record): string => $record->has_freebuild_whitelist ? 'far-circle-check' : 'far-circle-xmark')
                                    ->color(fn(GameUser $record): string => $record->has_freebuild_whitelist ? 'success' : 'danger')
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 8,
                            ]),
                        Section::make('Statistiken')
                            ->columns(1)
                            ->schema([
                                TextEntry::make('created_at')->label('Erstellt am')->dateTime(),
                                TextEntry::make('updated_at')->label('Aktualisiert am')->dateTime(),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
                            ]),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("uuid")
                    ->label("UUID")
                    ->length(36)
                    ->unique(GameUser::class, "uuid", ignorable: fn(?GameUser $record) => $record)
                    ->uuid()
                    ->required(),
                Forms\Components\TextInput::make("last_name")
                    ->label("Benutzername")
                    ->minLength(3)
                    ->maxLength(16)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("uuid")
                    ->label("UUID")->searchable(),
                Tables\Columns\TextColumn::make("username_with_fallback")
                    ->label("Benutzername")->searchable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->label("Erstellt am")
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])->label('Aktionen'),
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
            RelationManagers\NameHistoriesRelationManager::class,
            RelationManagers\BanRelationManager::class,
            RelationManagers\KicksRelationManager::class,
            RelationManagers\MutesRelationManager::class,
            RelationManagers\WarnsRelationManager::class,
            RelationManagers\WhitelistsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameUsers::route('/'),
            'view' => Pages\ViewGameUser::route('/{record}'),
//            'create' => Pages\CreateGameUser::route('/create'),
            'edit' => Pages\EditGameUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return GameUser::query()->count();
    }
}
