<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $isAdminOrEditor = $user && $user->hasAnyRole(['admin', 'editor']);

        $queryBuilder = function ($modelId) use ($isAdminOrEditor) {
            $query = Car::with('brands')->where('model_id', $modelId);
            if (!$isAdminOrEditor) {
                $query->where('status', 'Live')->where('moderation_status', 'published');
            }
            return $query->first();
        };

        $car1 = $request->has('car1') ? $queryBuilder($request->car1) : null;
        $car2 = $request->has('car2') ? $queryBuilder($request->car2) : null;
        $car3 = $request->has('car3') ? $queryBuilder($request->car3) : null;

        if (!$car1 && !$car2) {
            $defaultCars = Car::with('brands')
                ->where('status', 'Live')
                ->where('moderation_status', 'published')
                ->limit(3)
                ->get();
            $car1 = $defaultCars[0] ?? null;
            $car2 = $defaultCars[1] ?? null;
            $car3 = $defaultCars[2] ?? null;
        }

        // Log Comparison for Heatmap (Optimized)
        $uniquePairs = [];
        $ids = array_filter([$car1?->id, $car2?->id, $car3?->id]);
        sort($ids);
        
        for ($i = 0; $i < count($ids); $i++) {
            for ($j = $i + 1; $j < count($ids); $j++) {
                $pair = $ids[$i] . '-' . $ids[$j];
                if (!in_array($pair, $uniquePairs)) {
                    \App\Models\ComparisonLog::create(['car_a_id' => $ids[$i], 'car_b_id' => $ids[$j]]);
                    $uniquePairs[] = $pair;
                }
            }
        }
        
        // Increment counts
        foreach ($ids as $id) {
            Car::where('id', $id)->increment('comparison_count');
        }

        $allCarsQuery = Car::with('brands')->where('status', 'Live');
        if (!$isAdminOrEditor) {
            $allCarsQuery->where('moderation_status', 'published');
        }
        $allCars = $allCarsQuery->orderBy('model')->get();

        $differences = [];
        $cars = array_filter([$car1, $car2, $car3]);
        
        if (count($cars) >= 2) {
            $metrics = [
                'category', 'year', 'hp', 'torque', 'engine', 'transmission', 'drivetrain', 
                'zero_to_sixty', 'top_speed', 'aerodynamics', 'braking', 'brands',
                'min_price', 'max_price', 'data_completion'
            ];
            foreach ($metrics as $metric) {
                $values = [];
                foreach ($cars as $car) {
                    $val = $car->$metric;
                    if ($metric === 'brands') {
                        $val = $val->pluck('name')->sort()->values()->toJson();
                    }
                    if (is_array($val)) $val = json_encode($val);
                    $values[] = $val;
                }
                
                if (count(array_unique($values)) > 1) {
                    $differences[] = $metric;
                }
            }
        }

        return view('compare.index', compact('car1', 'car2', 'car3', 'allCars', 'differences'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'car1_id' => 'required|string',
            'car2_id' => 'required|string',
            'car3_id' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $user->comparisonSets()->create($request->all());

        return back()->with('success', 'Battle Set saved to your Garage.');
    }
}
