<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CarStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Specimens', Car::count())
                ->description('Active entries in technical database')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Manufacturer Index', Brand::count())
                ->description('Verified brands on file')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success'),
            Stat::make('Tactical Logs', Comment::count())
                ->description('Community discussions recorded')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('warning'),
        ];
    }
}
