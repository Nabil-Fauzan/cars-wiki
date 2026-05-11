<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataHealthWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $avgCompletion = Car::avg('data_completion') ?? 0;
        $missingSound = Car::whereNull('engine_sound_url')->count();
        $missingPrice = Car::whereNull('avg_price')->count();

        return [
            Stat::make('Avg Data Completion', round($avgCompletion, 1) . '%')
                ->description('Overall database health')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($avgCompletion > 80 ? 'success' : ($avgCompletion > 50 ? 'warning' : 'danger')),
            
            Stat::make('Missing Engine Sound', $missingSound)
                ->description('Cars without audio assets')
                ->descriptionIcon('heroicon-m-speaker-wave')
                ->color($missingSound > 0 ? 'warning' : 'success'),

            Stat::make('Price Data Gaps', $missingPrice)
                ->description('Cars without market valuation')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color($missingPrice > 0 ? 'danger' : 'success'),
        ];
    }
}
