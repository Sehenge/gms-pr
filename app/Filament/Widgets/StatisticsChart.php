<?php

namespace App\Filament\Widgets;

use App\Models\Statistic;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class StatisticsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static string $color = 'info';

    protected function getData(): array
    {
        /*$data = Trend::model(Statistic::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perDay();*/

        $data = Statistic::where('date', '<=', now())->orderBy('date', 'asc')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Sal',
                    'data' => $data->pluck('totalsal')->toArray(),
                    'borderColor' => 'rgb(255, 99, 132)',
                    'tension' => 0.1,
                    'fill' => true,
                ],
            ],
            'labels' => 'Project Sal',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
