<?php

namespace App\Filament\Resources\ContributionSuggestions\Pages;

use App\Filament\Resources\ContributionSuggestions\ContributionSuggestionResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Textarea;

class ViewContributionSuggestion extends ViewRecord
{
    protected static string $resource = ContributionSuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve Suggestion')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->getRecord()->status === 'pending')
                ->action(function () {
                    $suggestion = $this->getRecord();
                    $car = $suggestion->car;
                    $proposed = $suggestion->proposed_data;

                    // Apply all proposed spec corrections to the Car record
                    foreach ($proposed as $field => $newValue) {
                        if ($newValue !== null && $newValue !== '') {
                            $car->{$field} = $newValue;
                        }
                    }

                    $car->save();

                    // Award points and reputation score to the contributor
                    $contributor = $suggestion->user;
                    if ($contributor) {
                        $contributor->increment('reputation_score', 50);
                        $contributor->increment('points', 50);
                        
                        Notification::make()
                            ->title('Points Awarded')
                            ->body("User {$contributor->name} has received +50 points & reputation score.")
                            ->success()
                            ->send();
                    }

                    $suggestion->status = 'approved';
                    $suggestion->save();

                    Notification::make()
                        ->title('Spec Correction Approved')
                        ->body("Technical specs for {$car->model} successfully updated in database.")
                        ->success()
                        ->send();
                }),

            Action::make('reject')
                ->label('Reject Suggestion')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->visible(fn () => $this->getRecord()->status === 'pending')
                ->form([
                    Textarea::make('moderator_notes')
                        ->label('Reason for rejection')
                        ->required()
                        ->placeholder('e.g., Data could not be verified by technical sheets.'),
                ])
                ->action(function (array $data) {
                    $suggestion = $this->getRecord();
                    
                    $suggestion->status = 'rejected';
                    $suggestion->moderator_notes = $data['moderator_notes'];
                    $suggestion->save();

                    Notification::make()
                        ->title('Spec Correction Rejected')
                        ->body("The suggestion has been rejected and contribution queue updated.")
                        ->danger()
                        ->send();
                }),
        ];
    }
}
