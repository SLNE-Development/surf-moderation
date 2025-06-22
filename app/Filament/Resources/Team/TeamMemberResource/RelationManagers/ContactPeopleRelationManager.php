<?php

namespace App\Filament\Resources\Team\TeamMemberResource\RelationManagers;

use App\Models\Team\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactPeopleRelationManager extends RelationManager
{
    protected static string $relationship = 'contactPeople';

    protected static ?string $title = 'Kontaktpersonen';
    protected static ?string $label = 'Kontaktperson';
    protected static ?string $pluralLabel = 'Kontaktpersonen';

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
                Forms\Components\Select::make("contact_person_id")
                    ->label("Kontaktperson")
                    ->relationship("contactPerson", "username")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder("Wähle eine Kontaktperson")
                    ->helperText("Wähle eine Kontaktperson, die mit diesem Teammitglied verbunden ist.")
                    ->columnSpanFull()
                    ->options(fn() => TeamMember::all()
                        ->where('id', '!=', $this->ownerRecord->id)
                        ->pluck('username', 'id')
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('username')
            ->columns([
                Tables\Columns\TextColumn::make('username'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
