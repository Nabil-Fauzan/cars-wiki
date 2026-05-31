<?php

namespace App\Traits;

trait UserStatistics
{
    public function getGarageStatsAttribute(): array
    {
        $favorites = $this->favorites()->get();
        if ($favorites->isEmpty()) return [
            'total_hp' => 0,
            'fav_brand' => 'N/A',
            'era' => 'N/A',
            'total_value' => 0
        ];

        $totalHp = 0;
        $totalValue = 0;
        $brands = [];
        $eras = [];

        foreach ($favorites as $car) {
            $totalHp += (int) ($car->hp[0] ?? 0);
            $totalValue += (int) $car->avg_price;
            foreach ($car->brands as $brand) {
                $brands[] = $brand->name;
            }
            $year = (int) substr($car->year, 0, 4);
            $eras[] = $year < 1990 ? 'Classic' : ($year < 2010 ? 'Modern' : 'Contemporary');
        }

        $brandCounts = array_count_values($brands);
        arsort($brandCounts);
        
        $eraCounts = array_count_values($eras);
        arsort($eraCounts);

        return [
            'total_hp' => $totalHp,
            'fav_brand' => array_key_first($brandCounts) ?? 'N/A',
            'era' => array_key_first($eraCounts) ?? 'N/A',
            'total_value' => $totalValue
        ];
    }

    public function getContributionHeatmapAttribute(): array
    {
        $logs = $this->activityLogs()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $heatmap = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $heatmap[$date] = $logs[$date] ?? 0;
        }

        return $heatmap;
    }
}
