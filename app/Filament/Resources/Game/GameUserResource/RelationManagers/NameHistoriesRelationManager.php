<?php

namespace App\Filament\Resources\Game\GameUserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NameHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'nameHistories';

    protected static ?string $title = "Benutzernamen";
    protected static ?string $label = "Benutzername";
    protected static ?string $pluralLabel = "Benutzernamen";

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255),
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
            ->recordTitleAttribute('username')
            ->columns([
                Tables\Columns\TextColumn::make('username')->label('Benutzername')->sortable()->searchable(),
                Tables\Columns\TextColumn::make("created_at")->label("Erstellt am")->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
//                Tables\Actions\EditAction::make(),
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
