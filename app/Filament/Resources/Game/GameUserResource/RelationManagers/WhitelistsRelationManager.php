<?php

namespace App\Filament\Resources\Game\GameUserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class WhitelistsRelationManager extends RelationManager
{
    protected static string $relationship = 'whitelists';

    protected static ?string $title = 'Whitelists';
    protected static ?string $label = 'Whitelist';
    protected static ?string $pluralLabel = 'Whitelists';

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
                Forms\Components\Select::make('server')
                    ->label("Server")
                    ->options([
                        'freebuild' => 'Freebuild',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make("blocked")
                    ->label("Blockiert")
                    ->default(false)
                    ->helperText("Wenn aktiviert, wird die Whitelist für diesen Server blockiert und der Benutzer kann nicht darauf zugreifen.")
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('server')
            ->columns([
                Tables\Columns\TextColumn::make('server')
                    ->label('Server')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make("blocked")
                    ->label("Blockiert")
                    ->boolean()
                    ->color(function ($state) {
                        return $state ? 'danger' : 'success';
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('blocked')
                    ->label('Blockierte Whitelists')
                    ->query(fn($query) => $query->where('blocked', true)),
                Tables\Filters\Filter::make("freebuild_whitelist")
                    ->label("Freebuild Whitelist")
                    ->query(fn($query) => $query->where('server', 'freebuild')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data) {
                    $data["uuid"] = $this->ownerRecord->uuid;

                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
//                    Tables\Actions\EditAction::make(),
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
