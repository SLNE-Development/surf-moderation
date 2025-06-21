<?php

namespace App\Filament\Resources\Game\Punishment\BanResource\Pages;

use App\Filament\Resources\Game\Punishment\BanResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBan extends ViewRecord
{
    protected static string $resource = BanResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        $schema = [
            Section::make("Informationen")
                ->description("Allgemeine Informationen über den Ban")
                ->schema([
                    // Add fields for general information about the ban
                ]),
        ];

        if ($this->record->parentBan) {
            $schema[] = Section::make("Parent Ban")
                ->description("Informationen über den übergeordneten Ban")
                ->schema([
                    TextEntry::make('parentBan.punishment_id')
                        ->label('Parent Ban ID'),
                    TextEntry::make('parentBan.reason')
                        ->label('Grund'),
                    TextEntry::make('parentBan.gameUser.username_with_fallback')
                        ->label('Benutzername'),
                    TextEntry::make('parentBan.issuedBy.username_with_fallback')
                        ->label('Ausgestellt von'),
                ]);
        }

        return $infolist->schema($schema);
    }
}
