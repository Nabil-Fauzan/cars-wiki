<?php

namespace App\Filament\Widgets;

use App\Models\ComparisonLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class ComparisonHeatmapWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Enthusiast Comparison Heatmap';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ComparisonLog::select('car_a_id', 'car_b_id', DB::raw('count(*) as total'))
                    ->groupBy('car_a_id', 'car_b_id')
                    ->orderBy('total', 'desc')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('carA.model')
                    ->label('Specimen A')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('vs')
                    ->label('')
                    ->default('VS')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('carB.model')
                    ->label('Specimen B')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Battle Frequency')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-m-fire'),
            ]);
    }
}
