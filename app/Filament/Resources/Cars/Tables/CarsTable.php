<?php

namespace App\Filament\Resources\Cars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;
use App\Models\Car;

class CarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image_url')
                    ->label('Thumbnail')
                    ->circular(),
                TextColumn::make('model_id')
                    ->searchable()
                    ->copyable()
                    ->label('ID'),
                TextColumn::make('model')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('brands.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('year')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('transmission')
                    ->searchable(),
                TextColumn::make('drivetrain')
                    ->searchable(),
                TextColumn::make('torque')
                    ->searchable(),
                TextColumn::make('zero_to_sixty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('top_speed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('aerodynamics')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('braking')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('seo_score')
                    ->label('SEO')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    })
                    ->suffix('%'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Live' => 'success',
                        'Draft' => 'gray',
                        'Archived' => 'danger',
                    }),
                TextColumn::make('moderation_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'review' => 'warning',
                        'draft' => 'gray',
                    }),
                TextColumn::make('data_completion')
                    ->numeric()
                    ->sortable()
                    ->suffix('%'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'SUV' => 'SUV',
                        'Sedan' => 'Sedan',
                        'Coupe' => 'Coupe',
                        'Supercar' => 'Supercar',
                        'Hypercar' => 'Hypercar',
                        'Classic' => 'Classic',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Live' => 'Live',
                        'Draft' => 'Draft',
                        'Archived' => 'Archived',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('moderation_status')
                    ->options([
                        'draft' => 'Drafting',
                        'review' => 'Pending Review',
                        'published' => 'Published',
                    ]),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('scanLinks')
                    ->label('Scan Broken Links')
                    ->icon('heroicon-m-magnifying-glass')
                    ->color('warning')
                    ->action(function () {
                        $cars = \App\Models\Car::all();
                        foreach ($cars as $car) {
                            $isBroken = false;
                            if ($car->image_url) {
                                try {
                                    $response = \Illuminate\Support\Facades\Http::timeout(2)->head($car->image_url);
                                    if ($response->failed()) $isBroken = true;
                                } catch (\Exception $e) {
                                    $isBroken = true;
                                }
                            }
                            $car->update([
                                'has_broken_links' => $isBroken,
                                'last_link_check_at' => now(),
                            ]);
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('Link scan completed')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\Action::make('updateSeo')
                    ->label('Update SEO Scores')
                    ->icon('heroicon-m-arrow-path')
                    ->action(function () {
                        $cars = \App\Models\Car::all();
                        foreach ($cars as $car) {
                            $car->update(['seo_score' => $car->calculateSeoScore()]);
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('SEO scores recalculated')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\BulkAction::make('export_csv')
                        ->label('Export to CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $filename = "pcar_export_" . now()->format('Y-m-d_His') . ".csv";
                            $handle = fopen('php://temp', 'w+');
                            
                            // Headers
                            fputcsv($handle, ['Model ID', 'Model', 'Year', 'Category', 'HP', 'Top Speed', '0-60']);
                            
                            foreach ($records as $record) {
                                fputcsv($handle, [
                                    $record->model_id,
                                    $record->model,
                                    $record->year,
                                    $record->category,
                                    is_array($record->hp) ? implode('|', $record->hp) : $record->hp,
                                    $record->top_speed,
                                    $record->zero_to_sixty,
                                ]);
                            }
                            
                            rewind($handle);
                            $csv = stream_get_contents($handle);
                            fclose($handle);
                            
                            return response()->streamDownload(fn () => print($csv), $filename);
                        }),
                ]),
            ]);
    }
}
