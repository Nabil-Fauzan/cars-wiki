<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    public function suggestRevision(Request $request, Car $car)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (($car->status !== 'Live' || $car->moderation_status !== 'published') && (!$user || !$user->hasAnyRole(['admin', 'editor']))) {
            abort(403, 'This specimen is currently under classification and not yet public.');
        }

        $validated = $request->validate([
            'hp' => 'nullable|string|max:255',
            'torque' => 'nullable|string|max:255',
            'zero_to_sixty' => 'nullable|string|max:255',
            'top_speed' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'drivetrain' => 'nullable|string|max:255',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'engine_sound_url' => 'nullable|url|max:255',
        ]);

        // Filter out empty suggestions
        $proposedData = array_filter($validated, fn($val) => $val !== null && $val !== '');

        if (empty($proposedData)) {
            return back()->with('error', 'You must fill out at least one field to suggest a correction.');
        }

        // Format hp to array structure matching the database casts
        if (isset($proposedData['hp'])) {
            $proposedData['hp'] = [$proposedData['hp']];
        }

        \App\Models\ContributionSuggestion::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'proposed_data' => $proposedData,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your spec correction has been submitted to the moderation queue! Once approved, you will be awarded +50 points.');
    }
}
