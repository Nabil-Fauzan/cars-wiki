<?php

namespace App\Filament\Resources\ContributionSuggestions\Pages;

use App\Filament\Resources\ContributionSuggestions\ContributionSuggestionResource;
use Filament\Resources\Pages\ListRecords;

class ListContributionSuggestions extends ListRecords
{
    protected static string $resource = ContributionSuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
