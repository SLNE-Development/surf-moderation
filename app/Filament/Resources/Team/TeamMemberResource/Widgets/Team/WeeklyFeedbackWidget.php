<?php

namespace App\Filament\Resources\Team\TeamMemberResource\Widgets\Team;

use App\Models\Team\TeamMember;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget as BaseWidget;

class WeeklyFeedbackWidget extends BaseWidget
{
    protected static ?string $heading = 'Ticket-Statisik';

    protected static ?string $pollingInterval = null;

    public ?TeamMember $teamMember = null;

    protected int|string|array $columnSpan = "full";
    protected static ?string $maxHeight = '250px';

    private $colorMap = [
        'survival_support' => '#3b82f6',   // Blue
        'event_support' => '#22c55e',   // Green
        'discord_support' => '#a855f7',   // Purple
        'report' => '#f97316',   // Orange
        'whitelist' => '#10b981',   // Aqua
        'bugreport' => '#ef4444',   // Red
        'unban' => '#facc15',   // Yellow
    ];

    protected function getData(): array
    {
        if (!$this->teamMember) {
            return [
                "datasets" => [],
                "labels" => []
            ];
        }

        $weeksBack = 6;
        $now = Carbon::now();

        $types = [
            'survival_support',
            'event_support',
            'discord_support',
            'report',
            'whitelist',
            'bugreport',
            'unban',
        ];

        $weekRanges = [];
        $labels = [];
        $startOfThisWeek = $now->copy()->startOfWeek(CarbonInterface::SATURDAY);

        for ($i = $weeksBack - 1; $i >= 0; $i--) {
            $start = $startOfThisWeek->copy()->subWeeks($i);
            $end = $start->copy()->addDays(6)->endOfDay();

            $label = $start->format('d.m.') . '–' . $end->format('d.m.');
            $labels[] = $label;

            $weekRanges[] = [
                'start' => $start,
                'end' => $end,
                'label' => $label,
            ];
        }

        $tickets = $this->teamMember->closedTickets()
            ->whereBetween('closed_at', [$weekRanges[0]['start'], $weekRanges[$weeksBack - 1]['end']])
            ->get();

        $dataByType = [];
        foreach ($types as $type) {
            $dataByType[$type] = array_fill(0, $weeksBack, 0);
        }

        foreach ($tickets as $ticket) {
            $closedAt = Carbon::parse($ticket->closed_at);

            foreach ($weekRanges as $index => $range) {
                if ($closedAt->between($range['start'], $range['end'])) {
                    $type = $ticket->ticket_type;

                    if (in_array($type, $types)) {
                        $dataByType[$type][$index]++;
                    }

                    break;
                }
            }
        }

        $datasets = [];
        if ($this->getType() == "bar") {
            foreach ($dataByType as $type => $data) {
                $datasets[] = [
                    'label' => ucfirst(str_replace('_', ' ', $type)),
                    'data' => $data,
                    'borderColor' => $this->colorMap[$type] ?? '#9ca3af',
                    'backgroundColor' => $this->colorMap[$type] ?? '#9ca3af',
                ];
            }
        } else if ($this->getType() == "line") {
            foreach ($dataByType as $type => $data) {
                $datasets[] = [
                    'label' => ucfirst(str_replace('_', ' ', $type)),
                    'data' => $data,
                    'borderColor' => $this->colorMap[$type] ?? '#9ca3af',
                    'backgroundColor' => 'transparent',
                    'fill' => false,
                    'tension' => 0.3,
                ];
            }
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            "scales" => [
                "y" => [
                    "ticks" => [
                        "stepSize" => 1,
                        "precision" => 0,
                        "beginAtZero" => true,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return "bar";
    }
}
