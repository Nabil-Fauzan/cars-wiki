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
                TextColumn::make('price_range')
                    ->label('Price Range')
                    ->getStateUsing(fn (Car $record): string => 
                        $record->min_price ? 'Rp' . number_format($record->min_price) . ' - Rp' . number_format($record->max_price) : '-'
                    )
                    ->color('success'),
                TextColumn::make('marketplace_url')
                    ->label('Marketplace')
                    ->icon('heroicon-m-shopping-cart')
                    ->url(fn (Car $record): ?string => $record->marketplace_url)
                    ->openUrlInNewTab()
                    ->placeholder('-'),
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
                    ->suffix('%')
                    ->color(fn (int $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category'),
                \Filament\Tables\Filters\SelectFilter::make('status'),
                \Filament\Tables\Filters\SelectFilter::make('moderation_status'),
            ])
            ->actions([
                \Filament\Tables\Actions\ViewAction::make(),
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-m-document-duplicate')
                    ->color('gray')
                    ->action(function (Car $record) {
                        $newCar = $record->replicate();
                        $newCar->model_id = $record->model_id . '-COPY-' . strtoupper(\Illuminate\Support\Str::random(3));
                        $newCar->save();
                        
                        Notification::make()
                            ->title('Car duplicated successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                    \Filament\Tables\Actions\BulkAction::make('export_csv')
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
                            return response()->streamDownload(fn () => print($csv), $filename);
                        }),
                ]),
            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('scanLinks')
                    ->label('Scan Broken Links')
                    ->icon('heroicon-m-magnifying-glass')
                    ->color('warning')
                    ->action(function () {
                        // Scan logic...
                    }),
            ]);
    }
}
