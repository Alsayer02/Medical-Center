<?php

namespace App\Filament\Widgets;


use App\Models\Doctor;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class DoctortChart extends ChartWidget
{
    protected ?string $heading = 'Doctort Chart';

    protected function getData(): array
    {
        $data = Trend::model(Doctor::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Doctor',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
