<?php

namespace App\Filament\Resources\ContributionSuggestions;

use App\Filament\Resources\ContributionSuggestions\Pages\ListContributionSuggestions;
use App\Filament\Resources\ContributionSuggestions\Pages\ViewContributionSuggestion;
use App\Models\ContributionSuggestion;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;

class ContributionSuggestionResource extends Resource
{
    protected static ?string $model = ContributionSuggestion::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Moderation Queue';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Contributor')
                    ->badge()
                    ->searchable(),
                TextColumn::make('car.model')
                    ->label('Specimen')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Suggestion Details')
                    ->schema([
                        TextEntry::make('user.name')->label('Contributor')->badge(),
                        TextEntry::make('car.model')->label('Specimen')->weight('bold'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('created_at')->dateTime(),
                    ])->columns(2),

                Section::make('Specification Diff Engine')
                    ->schema([
                        ViewEntry::make('proposed_data')
                            ->label('Specification Diffs')
                            ->view('filament.components.diff-viewer')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContributionSuggestions::route('/'),
            'view' => ViewContributionSuggestion::route('/{record}'),
        ];
    }
}
