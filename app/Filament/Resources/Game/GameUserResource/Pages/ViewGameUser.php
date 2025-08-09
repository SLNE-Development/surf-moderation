<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages;

use App\Filament\Resources\Game\GameUserResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ViewGameUser extends ViewRecord
{
    protected static string $resource = GameUserResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\Action::make("Socials")
                ->icon('fas-hashtag')
                ->color("info")
                ->label("Socials2")
                ->modalHeading("Socials")
                ->modalSubmitActionLabel("Speichern")
                ->form([
                    TextInput::make('discord_id')
                        ->label('Discord ID')
                        ->required()
                        ->default(fn() => $this->getRecord()->socialConnection?->discord_id ?? '')
                        ->placeholder('123456789012345678'),

                    TextInput::make('twitch_id')
                        ->label('Twitch ID')
                        ->required()
                        ->default(fn() => $this->getRecord()->socialConnection?->twitch_id ?? '')
                        ->placeholder('ammo_dev'),
                ])->action(function (array $data) {
                    $twitchId = is_numeric($data['twitch_id']) ? $data['twitch_id'] : $this->fetchTwitchId($data['twitch_id']);

                    if (!$twitchId) {
                        Notification::make()
                            ->title("Twitch Id konnte nicht abgerufen werden")
                            ->danger()
                            ->send();

                        return;
                    }

                    $this->getRecord()->socialConnection()->updateOrCreate(
                        ['minecraft_uuid' => $this->getRecord()->uuid],
                        [
                            'discord_id' => $data['discord_id'],
                            'twitch_id' => $twitchId,
                        ]
                    );

                    Notification::make()
                        ->title("Socials aktualisiert")
                        ->success()
                        ->send();

                    return redirect()->to($this->getResource()::getUrl('view', ['record' => $this->getRecord()]));
                }),
            Actions\EditAction::make(),
        ];

        $socialConnection = $this->getRecord()->socialConnection;

        if ($socialConnection) {
            $actions = array_merge([
                Actions\Action::make('discord')
                    ->url($socialConnection->discord_url)
                    ->icon('fab-discord')
                    ->iconButton()
                    ->color('gray')
                    ->openUrlInNewTab(),

                Actions\Action::make('twitch')
                    ->url($socialConnection->twitch_url)
                    ->icon('fab-twitch')
                    ->iconButton()
                    ->color('gray')
                    ->openUrlInNewTab(),
            ], $actions);
        }

        return $actions;
    }

    /**
     * @throws ConnectionException
     */
    private function fetchTwitchId(string $twitchName): ?string
    {
        $twitchClientId = config('services.twitch.client_id');
        $twitchClientSecret = config('services.twitch.client_secret');

        $authResponse = Http::asForm()->post("https://id.twitch.tv/oauth2/token", [
            'client_id' => $twitchClientId,
            'client_secret' => $twitchClientSecret,
            'grant_type' => 'client_credentials',
        ]);

        if (!$authResponse->ok()) {
            Notification::make()
                ->title("Fehler beim Abrufen des Twitch Tokens")
                ->body("Bitte überprüfe die Twitch API Konfiguration.")
                ->danger()
                ->send();

            return null;
        }

        $accessToken = $authResponse["access_token"];

        $userResponse = Http::withHeaders([
            "Authorization" => "Bearer $accessToken",
            "Client-Id" => $twitchClientId,
        ])->get("https://api.twitch.tv/helix/users", [
            'login' => $twitchName,
        ]);

        if ($userResponse->ok() && count($userResponse["data"]) > 0) {
            return $userResponse["data"][0]["id"];
        }

        Notification::make()
            ->title("Fehler beim Abrufen der Twitch Id")
            ->body("Der Twitch Benutzername konnte nicht gefunden werden.")
            ->danger()
            ->send();

        return null;
    }
}
