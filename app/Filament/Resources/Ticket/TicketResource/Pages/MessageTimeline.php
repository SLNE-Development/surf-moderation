<?php

namespace App\Filament\Resources\Ticket\TicketResource\Pages;

use App\Filament\Resources\Ticket\TicketResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Computed;

class MessageTimeline extends Page
{
    use InteractsWithRecord {
        configureAction as configureActionRecord;
    }

    protected static string $resource = TicketResource::class;
    
    protected static ?string $title = "Nachrichten";

    protected static string $view = 'filament.resources.ticket.ticket-resource.pages.message-timeline';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canView($this->getRecord()), 403);
    }

    #[Computed]
    public function groupedMessages()
    {
        $messages = $this->record->messages()->get();

        return $messages->sortBy('created_at')->groupBy(function ($message) {
            return $message->created_at->format('Y-m-d');
        })->map(function ($group) {
            return $group->groupBy('message_id');
        })->all();
    }
}
