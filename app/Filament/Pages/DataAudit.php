<?php

namespace App\Filament\Pages;

use App\Models\Car;
use Filament\Pages\Page;

class DataAudit extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected string $view = 'filament.pages.data-audit';

    protected static ?string $title = 'Pusat Penjaminan Mutu';

    protected static ?string $navigationLabel = 'Pusat Penjaminan Mutu';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems';

    public function getViewData(): array
    {
        return [
            'lowCompletion' => Car::where('data_completion', '<', 60)->orderBy('data_completion')->get(),
            'missingPricing' => Car::whereNull('min_price')->orWhereNull('max_price')->orWhereNull('avg_price')->get(),
            'missingAudio' => Car::whereNull('engine_sound_url')->orWhere('engine_sound_url', '')->get(),
        ];
    }
}
