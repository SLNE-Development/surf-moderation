<?php

namespace App\Filament\Widgets;

use App\Models\Game\GameUser;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class GameUserIncreaseChart extends ChartWidget
{
    protected static ?string $heading = 'Benutzerzuwachs';

    protected function getData(): array
    {
        $firstUser = GameUser::query()
            ->orderBy('created_at', 'asc')
            ->first();

        $startDate = $firstUser && $firstUser->created_at->lessThan(now())
            ? $firstUser->created_at
            : now()->subMonths(6);

        $now = now();

        // users per month per month
        $data = Trend::model(GameUser::class)
            ->between(
                start: $startDate,
                end: $now
            )
            ->perMonth()
            ->count();

        return [
            "datasets" => [
                [
                    "label" => "Benutzerzuwachs",
                    "data" => $data->map(fn(TrendValue $value) => $value->aggregate),
                ]
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
