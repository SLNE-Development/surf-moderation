<?php

namespace App\Filament\Resources\Game\GameUserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReceivedTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'receivedTransactions';

    protected static ?string $title = 'Erhaltene Transaktionen';
    protected static ?string $label = 'Erhaltene Transaktion';
    protected static ?string $pluralLabel = 'Erhaltenen Transaktionen';

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
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
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->length(36),
                Forms\Components\Select::make("currency_id")
                    ->relationship("currency", "name")
                    ->createOptionForm([
                        Forms\Components\TextInput::make("name")
                            ->label("Name")
                            ->required()
                            ->minLength(3),
                        Forms\Components\TextInput::make("display_name")
                            ->label("Anzeigename")
                            ->required()
                            ->minLength(3),
                        Forms\Components\TextInput::make("decimal_places")
                            ->label("Dezimalstellen")
                            ->numeric()
                            ->default(2)
                            ->minValue(0)
                            ->maxValue(10),
                        Forms\Components\TextInput::make("symbol")
                            ->label("Symbol")
                            ->required()
                            ->minLength(1),
                        Forms\Components\TextInput::make("symbol_display")
                            ->label("Symbol Anzeige")
                            ->required()
                            ->minLength(1),
                    ])
                    ->label("Währung")
                    ->required(),
                Forms\Components\Select::make("sender_id")
                    ->relationship("sender", "last_name")
                    ->label("Absender")
                    ->required(),
                Forms\Components\TextInput::make("amount")
                    ->label("Betrag")
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1000000)
                    ->default(0),
                Forms\Components\Textarea::make('data')
                    ->label('Zusätzliche Daten')
                    ->rows(3)
                    ->maxLength(65535)
                    ->helperText('Hier können zusätzliche Informationen zur Transaktion gespeichert werden.'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('transaction_id')
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaktions Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency.name')
                    ->label('Währung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sender.last_name')
                    ->label('Absender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Betrag')
                    ->money('currency.symbol', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("currency_id")
                    ->label("Währung")
                    ->relationship("currency", "name")
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make("sender_id")
                    ->label("Absender")
                    ->relationship("sender", "last_name")
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data) {
                    $data["receiver_id"] = $this->ownerRecord->id;

                    return $data;
                }),
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
