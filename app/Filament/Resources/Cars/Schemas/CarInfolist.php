<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('model_id'),
                TextEntry::make('model'),
                TextEntry::make('year'),
                TextEntry::make('category')
                    ->placeholder('-'),
                TextEntry::make('transmission')
                    ->placeholder('-'),
                TextEntry::make('drivetrain')
                    ->placeholder('-'),
                TextEntry::make('torque')
                    ->placeholder('-'),
                TextEntry::make('zero_to_sixty')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('top_speed')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('aerodynamics')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('braking')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('history')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image_url')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('data_completion')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
