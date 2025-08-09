<?php

namespace App\Filament\Resources\Game\GameUserResource\Pages\Actions;

use App\Models\PunishmentTemplate;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;

class PunishGameUserAction
{

    static function buildAction()
    {
        return Action::make("CreatePunishmentWizard")
            ->label("Punish")
            ->icon("fas-gavel")
            ->color("danger")
            ->form([
                self::buildWizard()
            ]);
    }

    private static function buildWizard()
    {
        return Wizard::make([
            self::buildTemplateSelectStep()
        ]);
    }

    private static function buildTemplateSelectStep()
    {
        return Step::make("Vergehen auswählen")
            ->schema([
                Select::make('template_id')
                    ->label('Vergehen')
                    ->searchable()
                    ->placeholder('Wähle ein Vergehen aus')
                    ->helperText('Wähle ein Vergehen aus der Liste der verfügbaren Vorlagen.')
                    ->options(function () {
                        return PunishmentTemplate::all()
                            ->groupBy('category')
                            ->mapWithKeys(function ($group, $category) {
                                return [
                                    strtoupper($category) => $group->mapWithKeys(function ($template) {
                                        $duration = $template->duration > 0
                                            ? gmdate("H:i:s", $template->duration)
                                            : 'Permanent';

                                        $label = "$template->name ($duration) - " . $template->description;

                                        return [
                                            $template->id => $label,
                                        ];
                                    }),
                                ];
                            })
                            ->toArray();
                    })
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $template = PunishmentTemplate::find($state);
                        if ($template) {
                            $duration = $template->duration > 0
                                ? Carbon::now()->addSeconds($template->duration)->format('Y-m-d H:i:s')
                                : null;

                            $set('punishment_type', $template->punishment_type);
                            $set('reason', "Server - " . strtoupper($template->category) . " - " . $template->name);
                            $set('duration_until', $duration);
                        }
                    }),
            ]);
    }

}
