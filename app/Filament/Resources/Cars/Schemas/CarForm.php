<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Actions\Action;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('model')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (callable $set, $state) => $set('model_id', \Illuminate\Support\Str::slug($state))),
                        TextInput::make('model_id')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Specimen ID (Slug)'),
                        Select::make('brands')
                            ->relationship('brands', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
                        TextInput::make('year')
                            ->required()
                            ->numeric(),
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
                        TagsInput::make('hp')
                            ->label('Horsepower Ratings')
                            ->placeholder('e.g. 400 hp'),
                        TagsInput::make('engine')
                            ->label('Engine Options')
                            ->placeholder('e.g. 3.0L V6'),
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
                                    ->action(function (callable $set, $state, $get) {
                                        $model = $get('model');
                                        $response = \Illuminate\Support\Facades\Http::post(route('admin.ai.generate'), [
                                            'model' => $model,
                                            'field' => 'history'
                                        ]);
                                        if ($response->successful()) {
                                            $set('history', $response->json('content'));
                                        }
                                    })
                            ),
                        TagsInput::make('pros')
                            ->label('Pros')
                            ->placeholder('e.g. Fast acceleration')
                            ->hintAction(
                                Action::make('generatePros')
                                    ->icon('heroicon-m-sparkles')
                                    ->action(function (callable $set, $get) {
                                        $model = $get('model');
                                        $response = \Illuminate\Support\Facades\Http::post(route('admin.ai.generate'), [
                                            'model' => $model,
                                            'field' => 'pros'
                                        ]);
                                        if ($response->successful()) {
                                            $set('pros', json_decode($response->json('content'), true));
                                        }
                                    })
                            ),
                        TagsInput::make('cons')
                            ->label('Cons')
                            ->placeholder('e.g. High maintenance')
                            ->hintAction(
                                Action::make('generateCons')
                                    ->icon('heroicon-m-sparkles')
                                    ->action(function (callable $set, $get) {
                                        $model = $get('model');
                                        $response = \Illuminate\Support\Facades\Http::post(route('admin.ai.generate'), [
                                            'model' => $model,
                                            'field' => 'cons'
                                        ]);
                                        if ($response->successful()) {
                                            $set('cons', json_decode($response->json('content'), true));
                                        }
                                    })
                            ),
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
                        Select::make('moderation_status')
                            ->options([
                                'draft' => 'Drafting',
                                'review' => 'Pending Review',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('published'),
                        TextInput::make('data_completion')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->suffix('%'),
                    ])->columns(3),
            ]);
    }
}
