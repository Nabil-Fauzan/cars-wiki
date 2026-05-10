<?php

namespace App\Filament\Resources\Cars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('model_id')
                    ->searchable(),
                TextColumn::make('model')
                    ->searchable(),
                TextColumn::make('year')
                    ->searchable(),
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
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('data_completion')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('export_csv')
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
