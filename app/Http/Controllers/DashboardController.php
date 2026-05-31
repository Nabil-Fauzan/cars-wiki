<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Car::class);

        $query = Car::with('brands')->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('model', 'like', "%{$searchTerm}%")
                  ->orWhere('model_id', 'like', "%{$searchTerm}%")
                  ->orWhere('year', 'like', "%{$searchTerm}%")
                  ->orWhereHas('brands', function($bq) use ($searchTerm) {
                      $bq->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $cars = $query->get();
        $stats = [
            'total' => Car::count(),
            'completion' => Car::avg('data_completion') ?? 0,
        ];
        return view('dashboard', compact('cars', 'stats'));
    }
}
