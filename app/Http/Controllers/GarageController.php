<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $favorites = $user->favorites()->with('brands')->get();
        $comparisonSets = $user->comparisonSets()->with(['car1.brands', 'car2.brands', 'car3.brands'])->latest()->get();
        $personalNotes = $user->personalNotes()->with('car.brands')->latest()->get();

        return view('profile.garage', compact('favorites', 'comparisonSets', 'personalNotes'));
    }

    public function favorites()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cars = $user->favorites()->with('brands')->paginate(12)->withQueryString();
        
        // Stats for the sidebar/header
        $totalCars = Car::where('status', 'Live')->where('moderation_status', 'published')->count();
        $dailyCount = Car::where('status', 'Live')->where('moderation_status', 'published')->where('created_at', '>=', now()->subDay())->count();
        $averageCompletion = Car::where('status', 'Live')->where('moderation_status', 'published')->avg('data_completion') ?? 0;

        return view('favorites.index', compact('cars', 'totalCars', 'dailyCount', 'averageCompletion'));
    }

    public function toggleFavorite(Car $car)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->favorites()->toggle($car->id);
        
        return back()->with('success', 'Wishlist updated.');
    }

    public function rate(Request $request, Car $car)
    {
        $request->validate([
            'comfort' => 'required|integer|min:1|max:5',
            'performance' => 'required|integer|min:1|max:5',
            'design' => 'required|integer|min:1|max:5',
            'value' => 'required|integer|min:1|max:5',
        ]);

        $car->ratings()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['comfort', 'performance', 'design', 'value'])
        );

        return back()->with('success', 'Rating submitted.');
    }

    public function savePersonalNote(Request $request, Car $car)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->personalNotes()->updateOrCreate(
            ['car_id' => $car->model_id],
            ['content' => $request->content]
        );

        return back()->with('success', 'Personal note updated.');
    }
}
