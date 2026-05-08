<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('status', 'Live');
        
        if ($request->has('brand')) {
            $query->where('make', $request->brand);
        }

        $sort = $request->get('sort', 'newest');
        if ($sort == 'fastest') {
            $query->orderBy('top_speed', 'desc');
        } elseif ($sort == 'best') {
            $query->orderBy('data_completion', 'desc');
        } else {
            // Default newest - sorting by production year (string) or creation date
            $query->orderBy('year', 'desc')->latest();
        }

        $cars = $query->get();
        return view('welcome', compact('cars'));
    }

    public function brands()
    {
        $brands = Car::where('status', 'Live')
            ->select('make', DB::raw('count(*) as total'), DB::raw('MAX(image_url) as image'))
            ->groupBy('make')
            ->get();
        return view('brands.index', compact('brands'));
    }

    public function show(string $model_id)
    {
        $car = Car::where('model_id', $model_id)->firstOrFail();
        $rivals = Car::where('model_id', '!=', $model_id)->limit(2)->get();
        return view('cars.show', compact('car', 'rivals'));
    }

    public function dashboard()
    {
        $cars = Car::latest()->get();
        $stats = [
            'total' => Car::count(),
            'completion' => Car::avg('data_completion'),
        ];
        return view('dashboard', compact('cars', 'stats'));
    }

    public function compare(Request $request)
    {
        $car1 = $request->has('car1') ? Car::where('model_id', $request->car1)->first() : null;
        $car2 = $request->has('car2') ? Car::where('model_id', $request->car2)->first() : null;

        // If not provided, just get the first two
        if (!$car1 && !$car2) {
            $defaultCars = Car::where('status', 'Live')->limit(2)->get();
            $car1 = $defaultCars[0] ?? null;
            $car2 = $defaultCars[1] ?? null;
        }

        $allCars = Car::where('status', 'Live')->get();

        return view('compare.index', compact('car1', 'car2', 'allCars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_id' => 'required|unique:cars',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|string',
            'hp' => 'nullable|integer',
            'category' => 'nullable',
            'image_url' => 'nullable|url',
            'zero_to_sixty' => 'nullable|numeric',
            'top_speed' => 'nullable|integer',
            'aerodynamics' => 'nullable|numeric',
            'braking' => 'nullable|integer',
            'history' => 'nullable',
            'torque' => 'nullable',
            'transmission' => 'nullable',
            'drivetrain' => 'nullable',
        ]);

        $pros = $request->pros ? explode("\n", str_replace("\r", "", $request->pros)) : [];
        $cons = $request->cons ? explode("\n", str_replace("\r", "", $request->cons)) : [];
        $engine = array_filter([$request->engine_primary, $request->engine_secondary]);

        $car = Car::create($validated + [
            'pros' => array_filter($pros),
            'cons' => array_filter($cons),
            'engine' => $engine,
            'gallery' => [],
        ]);

        $car->update(['data_completion' => $this->calculateCompletion($car)]);

        return redirect()->route('dashboard')->with('success', 'Asset deployed successfully.');
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|string',
            'hp' => 'nullable|integer',
            'status' => 'required',
            'category' => 'nullable',
            'image_url' => 'nullable|url',
            'zero_to_sixty' => 'nullable|numeric',
            'top_speed' => 'nullable|integer',
            'aerodynamics' => 'nullable|numeric',
            'braking' => 'nullable|integer',
            'history' => 'nullable',
            'torque' => 'nullable',
            'transmission' => 'nullable',
            'drivetrain' => 'nullable',
        ]);

        $pros = $request->pros ? explode("\n", str_replace("\r", "", $request->pros)) : [];
        $cons = $request->cons ? explode("\n", str_replace("\r", "", $request->cons)) : [];
        $engine = array_filter([$request->engine_primary, $request->engine_secondary]);

        $car->update($validated + [
            'pros' => array_filter($pros),
            'cons' => array_filter($cons),
            'engine' => $engine,
        ]);

        $car->update(['data_completion' => $this->calculateCompletion($car)]);

        return redirect()->route('dashboard')->with('success', 'Asset synchronized successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('dashboard')->with('success', 'Asset decommissioned.');
    }

    private function calculateCompletion(Car $car): int
    {
        $fields = [
            'model_id', 'make', 'model', 'year', 'hp', 'category', 'image_url',
            'zero_to_sixty', 'top_speed', 'aerodynamics', 'braking',
            'history', 'engine', 'torque', 'transmission', 'drivetrain'
        ];

        $filled = 0;
        foreach ($fields as $field) {
            $val = $car->$field;
            if ($val !== null && $val !== '') {
                $filled++;
            }
        }

        // Handle arrays (pros/cons)
        if (is_array($car->pros) && count($car->pros) > 0) $filled++;
        if (is_array($car->cons) && count($car->cons) > 0) $filled++;

        $totalRequired = count($fields) + 2; // + pros + cons
        
        return (int) round(($filled / $totalRequired) * 100);
    }
}
