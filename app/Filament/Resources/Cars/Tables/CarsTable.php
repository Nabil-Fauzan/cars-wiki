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
                    ->label('Model ID'),
                TextColumn::make('model')
                    ->label('Model Name')
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
                \Filament\Tables\Columns\ViewColumn::make('engine_sound_url')
                    ->label('Exhaust Audio')
                    ->view('filament.components.audio-preview'),
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
                \Filament\Tables\Filters\SelectFilter::make('brands')
                    ->relationship('brands', 'name')
                    ->multiple()
                    ->preload(),
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->options(fn () => \App\Models\Car::query()
                        ->whereNotNull('category')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->toArray()
                    ),
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Live' => 'Live',
                        'Draft' => 'Draft',
                        'Archived' => 'Archived',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('moderation_status')
                    ->label('Moderation')
                    ->options([
                        'draft' => 'Drafting',
                        'review' => 'Pending Review',
                        'published' => 'Published',
                    ]),
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
                    BulkAction::make('export_excel')
                        ->label('Export to Excel')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $filename = "pcar_export_" . now()->format('Y-m-d_His') . ".xls";
                            
                            $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
                            $html .= '<head>';
                            $html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
                            $html .= '<style>';
                            $html .= 'table { border-collapse: collapse; font-family: "Segoe UI", "Inter", sans-serif; }';
                            $html .= 'th { background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase; }';
                            $html .= 'td { border: 1px solid #cbd5e1; padding: 8px 12px; font-size: 12px; color: #1e293b; }';
                            $html .= 'tr:nth-child(even) { background-color: #f8fafc; }';
                            $html .= '</style>';
                            $html .= '</head>';
                            $html .= '<body>';
                            $html .= '<table>';
                            $html .= '<thead>';
                            $html .= '<tr>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Model ID</th>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Model</th>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Year</th>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Category</th>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Price Min</th>';
                            $html .= '<th bgcolor="#98cbff" style="background-color: #98cbff; color: #0a0c10; font-weight: bold; border: 1px solid #64748b; padding: 10px 15px; text-align: left; font-size: 13px; text-transform: uppercase;">Price Max</th>';
                            $html .= '</tr>';
                            $html .= '</thead>';
                            $html .= '<tbody>';
                            
                            foreach ($records as $record) {
                                $html .= '<tr>';
                                $html .= '<td>' . htmlspecialchars($record->model_id) . '</td>';
                                $html .= '<td>' . htmlspecialchars($record->model) . '</td>';
                                $html .= '<td>' . htmlspecialchars($record->year) . '</td>';
                                $html .= '<td>' . htmlspecialchars($record->category) . '</td>';
                                $html .= '<td>$' . number_format($record->min_price ?? 0, 2) . '</td>';
                                $html .= '<td>$' . number_format($record->max_price ?? 0, 2) . '</td>';
                                $html .= '</tr>';
                            }
                            
                            $html .= '</tbody>';
                            $html .= '</table>';
                            $html .= '</body>';
                            $html .= '</html>';
                            
                            return response()->streamDownload(fn() => print($html), $filename);
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
