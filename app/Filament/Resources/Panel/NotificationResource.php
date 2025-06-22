<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\NotificationResource\Pages;
use App\Filament\Resources\Panel\NotificationResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class NotificationResource extends Resource
{
    protected static ?string $model = DatabaseNotification::class;

    protected static ?string $navigationGroup = 'Panel';
    protected static ?string $navigationBadgeTooltip = 'Anzahl ungelesener Benachrichtigungen';
    protected static ?string $navigationLabel = 'Benachrichtigungen';
    protected static ?string $navigationIcon = 'fas-bell';
    protected static ?int $navigationSort = 100;

    protected static ?string $label = 'Benachrichtigung';
    protected static ?string $pluralLabel = 'Benachrichtigungen';

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        $data = $record?->data ?? [];

        return $data['title'] ?? 'Unbekannt';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where("notifiable_type", get_class(auth()->user()))
            ->where("notifiable_id", auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("title")
                    ->label("Titel")
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                RichEditor::make("data")
                    ->label("Inhalt")
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Select::make("status")
                    ->label("Status")
                    ->options([
                        'info' => 'Information',
                        'success' => 'Erfolg',
                        'warning' => 'Warnung',
                        'danger' => 'Fehler',
                    ])
                    ->default('info')
                    ->required(),

                Select::make("color")
                    ->label("Farbe")
                    ->options([
                        'primary' => 'Primär',
                        'secondary' => 'Sekundär',
                        'success' => 'Erfolg',
                        'danger' => 'Fehler',
                        'warning' => 'Warnung',
                        'info' => 'Information',
                    ])
                    ->default('info')
                    ->required(),

                Select::make("recipients")
                    ->label("Empfänger")
                    ->options([
                        'Benutzer' => User::all()->mapWithKeys(function ($user) {
                            return ['user:' . $user->id => $user->name];
                        })->toArray(),
                        "Rollen" => []
                    ])
                    ->required()
                    ->multiple()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("data")
                    ->label("Titel")
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        $data = json_decode($state, true) ?? [];

                        return $data->title ?? 'Unbekannt';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
//                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return DatabaseNotification::where("notifiable_type", get_class(auth()->user()))->where("notifiable_id", auth()->id())->count();
    }
}
