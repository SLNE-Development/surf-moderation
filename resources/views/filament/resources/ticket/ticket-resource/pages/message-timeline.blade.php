<x-filament-panels::page>
    <div class="flex flex-col gap-8">
        @foreach ($this->groupedMessages as $date => $messageGroups)
            <div class="flex flex-col gap-4 w-full items-start">
                <div class="font-semibold text-sm px-2 py-1 bg-primary-500 rounded-xl shadow-sm">
                    {{ \Carbon\Carbon::parse($date)->format('d.m.Y') }}
                </div>

                @foreach ($messageGroups as $messageId => $messages)
                    @php
                        $firstMessage = $messages->first();
                        $messageHistory = $messages->filter(function ($message) use ($firstMessage) {;
                            return $message->id !== $firstMessage->id;
                        });

                        $botMessage = $firstMessage->bot_message ?? false;
                        $firstMessageLabel = "erstellt";
                        $firstMessageIcon = "fas-plus";
                        if($firstMessage->message_edited_at) {
                            $firstMessageLabel = "bearbeitet";
                            $firstMessageIcon = "fas-edit";
                        } elseif($firstMessage->message_deleted_at) {
                            $firstMessageLabel = "gelöscht";
                            $firstMessageIcon = "fas-trash";
                        }
                    @endphp

                    <div class="w-full">
                        <div
                            class="w-full flex flex-col bg-white dark:bg-gray-900 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 before:block">
                            <div class="w-full rounded-t-xl border-b">
                                <div class="flex justify-between p-2 items-center">
                                    <div class="flex flex-row items-center gap-2">
                                        <img src="{{$firstMessage->author_avatar_url }}"
                                             alt="Avatar" class="rounded-full h-8 w-8"/>

                                        <div>{{ $firstMessage->author->last_name ?? 'Unbekannt' }}</div>

                                        @if($botMessage)
                                            <x-filament::icon
                                                icon="fas-robot"
                                                class="w-6 h-6"
                                            />
                                        @endif
                                    </div>

                                    <div
                                        class="text-gray-400 flex flex-row text-xs gap-2 items-center">
                                        <span>Nachricht {{$firstMessageLabel}}</span>

                                        <x-filament::icon
                                            icon="{{ $firstMessageIcon }}"
                                            class="w-4 h-4"
                                        />

                                        <span>{{ $firstMessage->created_at->format('H:i:s') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-1 p-4">
                                <span class="font-bold">Nachricht:</span>
                                <p class="">{{ $firstMessage->json_content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
