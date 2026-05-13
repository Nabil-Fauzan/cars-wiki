<?php

namespace App\Filament\Resources\Cars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
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
                TextColumn::make('price_range')
                    ->label('Price Range')
                    ->getStateUsing(
                        fn(Car $record): string =>
                        $record->min_price ? '$' . number_format($record->min_price) . ($record->max_price ? ' - $' . number_format($record->max_price) : '+') : '-'
                    )
                    ->color('success')
                    ->sortable(['min_price']),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Live' => 'success',
                        'Draft' => 'gray',
                        'Archived' => 'danger',
                    }),
                TextColumn::make('moderation_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'published' => 'success',
                        'review' => 'warning',
                        'draft' => 'gray',
                    }),
                TextColumn::make('data_completion')
                    ->label('Data Completion')
                    ->html()
                    ->formatStateUsing(function ($state): string {
                        $percentage = (int) ($state ?? 0);
                        $color = match (true) {
                            $percentage >= 90 => '#22c55e',
                            $percentage >= 70 => '#3b82f6',
                            $percentage >= 40 => '#f59e0b',
                            default => '#ef4444',
                        };

                        return "
                            <div style='display: flex; align-items: center; gap: 8px; width: 100px;'>
                                <div style='flex-grow: 1; height: 6px; background-color: rgba(0,0,0,0.1); border-radius: 3px; overflow: hidden;'>
                                    <div style='width: {$percentage}%; height: 100%; background-color: {$color};'></div>
                                </div>
                                <span style='font-size: 10px; font-weight: 700;'>{$percentage}%</span>
                            </div>
                        ";
                    })
                    ->sortable(),
                TextColumn::make('history')
                    ->limit(20)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category'),
                \Filament\Tables\Filters\SelectFilter::make('status'),
                \Filament\Tables\Filters\SelectFilter::make('moderation_status'),
                \Filament\Tables\Filters\TernaryFilter::make('has_sound')
                    ->label('Has Engine Sound')
                    ->queries(
                        true: fn($query) => $query->whereNotNull('engine_sound_url'),
                        false: fn($query) => $query->whereNull('engine_sound_url'),
                    ),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('duplicate')
                    ->icon('heroicon-m-document-duplicate')
                    ->color('gray')
                    ->action(function (Car $record) {
                        $newCar = $record->replicate();
                        $newCar->model_id = $record->model_id . '-COPY-' . strtoupper(\Illuminate\Support\Str::random(3));

                        // Reset stats for new entry
                        $newCar->comparison_count = 0;
                        $newCar->seo_score = 0;
                        $newCar->status = 'Draft';
                        $newCar->moderation_status = 'draft';

                        $newCar->save();

                        // Copy many-to-many brands
                        $newCar->brands()->sync($record->brands->pluck('id'));

                        Notification::make()
                            ->title('Asset duplicated as Draft')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('export_csv')
                        ->label('Export to CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $filename = "pcar_export_" . now()->format('Y-m-d_His') . ".csv";
                            $handle = fopen('php://temp', 'w+');
                            fputcsv($handle, ['Model ID', 'Model', 'Year', 'Category', 'Price Min', 'Price Max']);
                            foreach ($records as $record) {
                                fputcsv($handle, [$record->model_id, $record->model, $record->year, $record->category, $record->min_price, $record->max_price]);
                            }
                            rewind($handle);
                            $csv = stream_get_contents($handle);
                            fclose($handle);
                            return response()->streamDownload(fn() => print($csv), $filename);
                        }),
                ]),
            ])
            ->headerActions([
                Action::make('scanLinks')
                    ->label('Scan Broken Links')
                    ->icon('heroicon-m-magnifying-glass')
                    ->color('warning')
                    ->action(function () {
                        $cars = Car::whereNotNull('image_url')->get();
                        $brokenCount = 0;

                        foreach ($cars as $car) {
                            try {
                                $response = Http::timeout(2)->head($car->image_url);
                                if ($response->failed()) {
                                    $brokenCount++;
                                    // Log or flag the record if needed
                                }
                            } catch (\Exception $e) {
                                $brokenCount++;
                            }
                        }

                        Notification::make()
                            ->title('Scan Completed')
                            ->body("Scanned {$cars->count()} cars. Found approximately {$brokenCount} potentially broken image links.")
                            ->warning()
                            ->send();
                    }),
            ]);
    }
}
