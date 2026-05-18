<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('model')
                            ->label('Model Name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $year = $get('year');
                                $slug = Str::slug($state);
                                if ($year) $slug .= '-' . $year;
                                $set('model_id', $slug);
                            }),
                        TextInput::make('model_id')
                            ->label('Model ID')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('brands')
                            ->relationship('brands', 'name')
                            ->multiple()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                // Auto-sync 'make' from the first selected brand
                                if (!empty($state)) {
                                    $brandId = is_array($state) ? $state[0] : $state;
                                    $brand = \App\Models\Brand::find($brandId);
                                    if ($brand) $set('make', $brand->name);
                                } else {
                                    $set('make', null);
                                }
                            }),
                        TextInput::make('year')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $model = $get('model');
                                if ($model) {
                                    $slug = Str::slug($model) . '-' . $state;
                                    $set('model_id', $slug);
                                }
                            }),
                        TextInput::make('category')
                            ->datalist(fn () => \App\Models\Car::query()
                                ->whereNotNull('category')
                                ->distinct()
                                ->orderBy('category')
                                ->pluck('category')
                                ->toArray()
                            )
                            ->required(),
                        TextInput::make('make')
                            ->hidden() // Keeping it for DB integrity but hidden from user as they select via 'brands'
                            ->dehydrated(true),
                    ])->columns(2),

                Section::make('Performance Specs')
                    ->schema([
                        TagsInput::make('hp')
                            ->label('Horsepower Ratings')
                            ->placeholder('e.g. 400 hp'),
                        TagsInput::make('engine')
                            ->label('Engine Options')
                            ->placeholder('e.g. 3.0L V6'),
                        TextInput::make('transmission'),
                        TextInput::make('drivetrain'),
                        TagsInput::make('torque')
                            ->label('Torque Ratings')
                            ->placeholder('e.g. 350 lb-ft'),
                        TextInput::make('zero_to_sixty')
                            ->label('0-60')
                            ->placeholder('e.g. ~7.0 detik (NA) dan ~6.0 detik (Turbo)'),
                        TextInput::make('top_speed')
                            ->placeholder('e.g. 180 mph / 290 km/h'),
                        TextInput::make('aerodynamics')
                            ->placeholder('e.g. 0.32 Cd'),
                        TextInput::make('braking')
                            ->label('Braking')
                            ->placeholder('e.g. 112 ft / 34 m'),
                    ])->columns(3),

                Section::make('Visuals & Content')
                    ->schema([
                        TextInput::make('image_url')
                            ->label('Main Image URL')
                            ->url(),
                        TagsInput::make('gallery')
                            ->label('Gallery URLs')
                            ->placeholder('Paste image URLs here'),
                        Textarea::make('history')
                            ->columnSpanFull()
                            ->hintAction(
                                Action::make('generateHistory')
                                     ->icon('heroicon-m-sparkles')
                                     ->label('AI Magic')
                                     ->action(function (Set $set, Get $get) {
                                         $model = $get('model');
                                         if (!$model) return;
                                         
                                         $aiResponse = app(\App\Http\Controllers\Admin\CarAiController::class)->generate(
                                             new \Illuminate\Http\Request([
                                                 'model' => $model,
                                                 'field' => 'history'
                                             ])
                                         );
                                         
                                         $content = json_decode($aiResponse->getContent(), true)['content'] ?? null;
                                         if ($content) {
                                             $set('history', $content);
                                         }
                                     })
                            ),
                        TagsInput::make('pros')
                            ->label('Pros')
                            ->placeholder('e.g. Fast acceleration')
                            ->hintAction(
                                Action::make('generatePros')
                                    ->icon('heroicon-m-sparkles')
                                    ->action(function (Set $set, Get $get) {
                                        $model = $get('model');
                                        if (!$model) return;

                                        $aiResponse = app(\App\Http\Controllers\Admin\CarAiController::class)->generate(
                                            new \Illuminate\Http\Request([
                                                'model' => $model,
                                                'field' => 'pros'
                                            ])
                                        );
                                        
                                        $content = json_decode($aiResponse->getContent(), true)['content'] ?? null;
                                        if ($content) {
                                            $data = is_string($content) ? json_decode($content, true) : $content;
                                            if (is_array($data)) $set('pros', $data);
                                        }
                                    })
                            ),
                        TagsInput::make('cons')
                            ->label('Cons')
                            ->placeholder('e.g. High maintenance')
                            ->hintAction(
                                Action::make('generateCons')
                                    ->icon('heroicon-m-sparkles')
                                    ->action(function (Set $set, Get $get) {
                                        $model = $get('model');
                                        if (!$model) return;

                                        $aiResponse = app(\App\Http\Controllers\Admin\CarAiController::class)->generate(
                                            new \Illuminate\Http\Request([
                                                'model' => $model,
                                                'field' => 'cons'
                                            ])
                                        );
                                        
                                        $content = json_decode($aiResponse->getContent(), true)['content'] ?? null;
                                        if ($content) {
                                            $data = is_string($content) ? json_decode($content, true) : $content;
                                            if (is_array($data)) $set('cons', $data);
                                        }
                                    })
                            ),
                    ])->columns(2),

                Section::make('Marketplace & Audio')
                    ->schema([
                        TextInput::make('marketplace_url')
                            ->label('Marketplace URL')
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('engine_sound_url')
                            ->label('Engine Sound URL')
                            ->url()
                            ->hint(fn ($state) => $state ? view('filament.components.audio-preview', [
                                'state' => $state,
                                'getState' => fn () => $state,
                            ]) : null),
                        TextInput::make('min_price')
                            ->label('Entry Price')
                            ->prefix('$')
                            ->placeholder('e.g. 55000')
                            ->helperText('Accepts numeric values. Formatting applied in frontend.'),
                        TextInput::make('max_price')
                            ->label('Peak Price')
                            ->prefix('$')
                            ->placeholder('e.g. 180000'),
                        TextInput::make('avg_price')
                            ->label('Market Average')
                            ->prefix('$')
                            ->helperText('Auto-calculated if left blank.'),
                        Select::make('price_trend')
                            ->options([
                                'up' => 'Trending Up',
                                'down' => 'Trending Down',
                                'stable' => 'Stable',
                            ]),
                    ])->columns(2),

                Section::make('System Metrics')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'Live' => 'Live',
                                'Draft' => 'Draft',
                                'Archived' => 'Archived',
                            ])
                            ->required()
                            ->default('Live'),
                        Select::make('moderation_status')
                            ->options([
                                'draft' => 'Drafting',
                                'review' => 'Pending Review',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('published'),
                        TextInput::make('seo_score')
                            ->numeric()
                            ->label('SEO Score')
                            ->default(0),
                        TextInput::make('data_completion')
                            ->label('Data Quality')
                            ->disabled()
                            ->dehydrated(false)
                            ->numeric()
                            ->suffix('%')
                            ->helperText('Calculated based on field density.'),
                    ])->columns(2),
            ]);
    }
}
