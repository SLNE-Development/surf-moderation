<?php

namespace App\Filament\Resources\Team\Feedback;

use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\Pages;
use App\Filament\Resources\Team\Feedback\TeamMemberFeedbackResource\RelationManagers;
use App\Models\Team\Feedback\TeamMemberFeedback;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TeamMemberFeedbackResource extends Resource
{
    protected static ?string $model = TeamMemberFeedback::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $label = 'Teammitglied Feedback';
    protected static ?string $pluralLabel = 'Teammitglied Feedbacks';

    public static function canEdit(Model $record): bool
    {
        return parent::canEdit($record) && !$record->closed;
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
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
            RelationManagers\EntriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMemberFeedback::route('/'),
            'view' => Pages\ViewTeamMemberFeedback::route('/{record}'),
//            'create' => Pages\CreateTeamMemberFeedback::route('/create'),
            'edit' => Pages\EditTeamMemberFeedback::route('/{record}/edit'),
        ];
    }
}
