<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class UserInteractionWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $mostFavorited = Car::orderBy('favorite_count', 'desc')->first();
        $totalBattles = Car::sum('comparison_count');

        return [
            Stat::make('Total Enthusiasts', $totalUsers)
                ->description('Registered accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Most Wanted', $mostFavorited ? $mostFavorited->model : 'None')
                ->description('Most favorited vehicle')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),

            Stat::make('Technical Battles', $totalBattles)
                ->description('Total vehicle comparisons')
                ->descriptionIcon('heroicon-m-swatches')
                ->color('success'),
        ];
    }
}
