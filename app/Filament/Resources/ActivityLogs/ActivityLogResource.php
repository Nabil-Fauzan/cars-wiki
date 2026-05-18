<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages;
use Spatie\Activitylog\Models\Activity;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    protected static string|\UnitEnum|null $navigationGroup = 'Security';
    protected static ?string $modelLabel = 'Audit Log';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Timestamp'),
                TextColumn::make('causer.name')
                    ->label('Admin')
                    ->searchable()
                    ->placeholder('System'),
                TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('subject_type')
                    ->label('Resource')
                    ->formatStateUsing(fn ($state) => class_basename($state)),
                TextColumn::make('subject_id')
                    ->label('Subject ID'),
                TextColumn::make('properties')
                    ->label('Metadata')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Audit Details')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Timestamp')
                            ->dateTime()
                            ->badge(),
                        TextEntry::make('causer.name')
                            ->label('Operator / Admin')
                            ->placeholder('System')
                            ->weight('bold'),
                        TextEntry::make('description')
                            ->label('Action')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'created' => 'success',
                                'updated' => 'warning',
                                'deleted' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('subject_type')
                            ->label('Target Resource')
                            ->formatStateUsing(fn ($state) => class_basename($state)),
                        TextEntry::make('subject_id')
                            ->label('Target Subject ID'),
                    ])->columns(2),

                Section::make('Data Changes (JSON Metadata)')
                    ->schema([
                        TextEntry::make('properties')
                            ->label('State Properties')
                            ->fontFamily('mono')
                            ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
