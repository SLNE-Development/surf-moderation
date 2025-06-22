<?php

namespace App\Filament\Resources\Ticket\TicketResource\Pages;

use App\Filament\Resources\Ticket\TicketResource;
use Filament\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("timeline")
                ->label("Timeline")
                ->icon("fas-clock")
                ->url(fn() => route("filament.admin.resources.ticket.tickets.timeline", $this->record))
                ->openUrlInNewTab(),
//            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $schema = [
            Section::make('Allgemeine Infos')
                ->columns()
                ->schema([
                    TextEntry::make('id')->label('ID'),
                    TextEntry::make('ticket_id')->label('Ticket ID'),
                    TextEntry::make('ticket_type_label')->label('Ticket Typ'),
                    TextEntry::make('ticket_author_id')->label('Ticket Autor ID'),
                    TextEntry::make('ticket_author_name')->label('Ticket Autor Name'),
                    ImageEntry::make('ticket_author_avatar_url')
                        ->label('Ticket Autor Avatar')
                        ->circular()
                        ->size(64),
                ]),

            Section::make('Guild & Thread')
                ->columns()
                ->schema([
                    TextEntry::make('guild_id')->label('Guild ID'),
                    TextEntry::make('thread_id')->label('Thread ID'),
                ]),

            Section::make('Zeitstempel')
                ->columns()
                ->schema([
                    TextEntry::make('opened_at')
                        ->label('Eröffnet am')
                        ->dateTime()
                        ->columnSpanFull(),

                    TextEntry::make('created_at')
                        ->label('Erstellt am')
                        ->dateTime(),

                    TextEntry::make('updated_at')
                        ->label('Aktualisiert am')
                        ->dateTime(),
                ]),
        ];

        if ($this->record->closed_at) {
            $schema[] = Section::make('Geschlossen')
                ->columns()
                ->schema([
                    TextEntry::make('closed_at')
                        ->label('Geschlossen am')
                        ->dateTime(),

                    TextEntry::make('closed_by_id')
                        ->label('Geschlossen durch ID'),

                    TextEntry::make('closed_by_name')
                        ->label('Geschlossen durch Name'),

                    ImageEntry::make('closed_by_avatar_url')
                        ->label('Geschlossen durch Avatar')
                        ->circular()
                        ->size(64),

                    TextEntry::make('closed_reason')
                        ->label('Grund'),
                ]);
        }

        return $infolist->schema($schema);
    }
}
