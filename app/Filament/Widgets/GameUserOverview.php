<?php

namespace App\Filament\Widgets;

use App\Models\Game\GameUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GameUserOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Benutzer", GameUser::query()->count()),
        ];
    }
}
