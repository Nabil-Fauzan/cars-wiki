<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('model_id')
                            ->required()
                            ->label('Specimen ID (Slug)'),
                        TextInput::make('model')
                            ->required(),
                        Select::make('brands')
                            ->relationship('brands', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
                        TextInput::make('year')
                            ->required(),
                        Select::make('category')
                            ->options([
                                'SUV' => 'SUV',
                                'Sedan' => 'Sedan',
                                'Coupe' => 'Coupe',
                                'Supercar' => 'Supercar',
                                'Hypercar' => 'Hypercar',
                                'Classic' => 'Classic',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Performance Specs')
                    ->schema([
                        TextInput::make('hp')
                            ->label('Horsepower Ratings (JSON)')
                            ->helperText('Format: ["400 hp", "450 hp"]'),
                        TextInput::make('engine')
                            ->label('Engine Options (JSON)')
                            ->helperText('Format: ["3.0L V6", "4.0L V8"]'),
                        TextInput::make('transmission'),
                        TextInput::make('drivetrain'),
                        TextInput::make('torque'),
                        TextInput::make('zero_to_sixty')
                            ->numeric()
                            ->step(0.1),
                        TextInput::make('top_speed')
                            ->numeric(),
                        TextInput::make('aerodynamics')
                            ->numeric()
                            ->step(0.01),
                        TextInput::make('braking')
                            ->numeric()
                            ->label('Braking (ft)'),
                    ])->columns(3),

                Section::make('Visuals & Content')
                    ->schema([
                        TextInput::make('image_url')
                            ->label('Main Image URL'),
                        TextInput::make('gallery')
                            ->label('Gallery URLs (JSON)'),
                        Textarea::make('history')
                            ->columnSpanFull(),
                        TextInput::make('pros')
                            ->label('Pros (JSON)'),
                        TextInput::make('cons')
                            ->label('Cons (JSON)'),
                    ])->columns(2),

                Section::make('System Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'Live' => 'Live',
                                'Draft' => 'Draft',
                                'Archived' => 'Archived',
                            ])
                            ->required()
                            ->default('Live'),
                        TextInput::make('data_completion')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->suffix('%'),
                    ])->columns(2),
            ]);
    }
}
