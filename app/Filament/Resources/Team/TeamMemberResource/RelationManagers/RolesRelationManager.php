<?php

namespace App\Filament\Resources\Team\TeamMemberResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $title = 'Rollen';
    protected static ?string $label = 'Rolle';
    protected static ?string $pluralLabel = 'Rollen';

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
                Forms\Components\Select::make("role")
                    ->label("Rolle")
                    ->required()
                    ->options([
                        "administrator" => "Administrator",
                        "management" => "Management",
                        "developer" => "Entwickler",
                        "builder" => "Builder",
                        "moderator" => "Moderator",
                        "moderator-a" => "Moderator A",
                        "supporter" => "Supporter",
                        "supporter-a" => "Supporter A",
                    ])
                    ->searchable()
                    ->placeholder("Wähle eine Rolle")
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make("assigned_at")
                    ->label("Zugewiesen am")
                    ->seconds(false)
                    ->required()
                    ->default(now())
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('role')
            ->defaultSort('assigned_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->label('Rolle')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_at')
                    ->label('Zugewiesen am')
                    ->dateTime("d.m.Y H:i")
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }
}
