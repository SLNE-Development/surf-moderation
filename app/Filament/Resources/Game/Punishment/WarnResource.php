<?php

namespace App\Filament\Resources\Game\Punishment;

use App\Filament\Resources\Game\Punishment\WarnResource\Pages;
use App\Filament\Resources\Game\Punishment\WarnResource\RelationManagers;
use App\Models\Game\Punishment\Warn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class WarnResource extends Resource
{
    protected static ?string $model = Warn::class;

    protected static ?string $navigationGroup = "Punishments";
    protected static ?string $navigationLabel = 'Verwarnungen';
    protected static ?string $navigationIcon = 'fas-triangle-exclamation';

    protected static ?string $breadcrumb = 'Verwarnungen';

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return "Mute-" . $record->punishment_id;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['punishment_id'];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('punishment_id')
                    ->label('Punishment Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gameUser.username_with_fallback')
                    ->label('Benutzername'),
                Tables\Columns\TextColumn::make("reason")
                    ->label("Grund")
                    ->words(10)
                    ->wrap()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        $wordSplit = explode(' ', $state);

                        return sizeof($wordSplit) <= $column->getWordLimit() ?
                            null : $state;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make("issuedBy.username_with_fallback")
                    ->label("Ausgeführt durch")
                    ->searchable(),
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
                    Tables\Actions\DeleteAction::make()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarns::route('/'),
            'view' => Pages\ViewWarn::route('/{record}'),
//            'create' => Pages\CreateWarn::route('/create'),
            'edit' => Pages\EditWarn::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Warn::query()->count();
    }
}
