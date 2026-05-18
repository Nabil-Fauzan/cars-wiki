<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use App\Models\Car;
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
                    ->label('0-60')
                    ->placeholder('-'),
                TextEntry::make('top_speed')
                    ->placeholder('-'),
                TextEntry::make('aerodynamics')
                    ->placeholder('-'),
                TextEntry::make('braking')
                    ->placeholder('-'),
                TextEntry::make('price_range')
                    ->label('Price Range')
                    ->getStateUsing(fn (Car $record): string => 
                        $record->min_price ? 'Rp' . number_format($record->min_price) . ' - Rp' . number_format($record->max_price) : '-'
                    )
                    ->color('success'),
                TextEntry::make('marketplace_url')
                    ->label('Marketplace')
                    ->icon('heroicon-m-shopping-cart')
                    ->url(fn (Car $record): ?string => $record->marketplace_url)
                    ->openUrlInNewTab(),
                TextEntry::make('engine_sound_url')
                    ->label('Engine Audio')
                    ->icon('heroicon-m-speaker-wave')
                    ->url(fn (Car $record): ?string => $record->engine_sound_url)
                    ->openUrlInNewTab(),
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
