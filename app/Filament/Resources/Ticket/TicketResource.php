<?php

namespace App\Filament\Resources\Ticket;

use App\Filament\Resources\Ticket\TicketResource\Pages;
use App\Filament\Resources\Ticket\TicketResource\RelationManagers;
use App\Models\Ticket\Ticket;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationGroup = "Discord";
    protected static ?int $navigationSort = 45;
    protected static ?string $navigationIcon = 'fas-ticket';

    protected static ?string $label = 'Ticket';
    protected static ?string $pluralLabel = 'Tickets';

    public static function getNavigationBadge(): ?string
    {
        return Ticket::query()->count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
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
                Tables\Columns\TextColumn::make("ticket_author_name")
                    ->label("Autor")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("ticket_type_label")
                    ->label("Typ")
                    ->sortable(),
                Tables\Columns\TextColumn::make("opened_at")
                    ->label("Eröffnet am")
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('closed_at')
                    ->label('Geschlossen am')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
            'timeline' => Pages\MessageTimeline::route('/{record}/timeline'),
        ];
    }
}
