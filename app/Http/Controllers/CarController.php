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
        
        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        // Brand Filter
        if ($request->filled('brand')) {
            $query->where('make', $request->brand);
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Horsepower Filter (e.g. 400+, 600+)
        if ($request->filled('hp')) {
            $minHp = (int) str_replace('+', '', $request->hp);
            // Since hp is JSON array of strings like ["145 hp (NA)"], 
            // we use whereRaw to extract the first number and compare.
            $query->whereRaw("CAST(REGEXP_REPLACE(JSON_UNQUOTE(JSON_EXTRACT(hp, '$[0]')), '[^0-9]', '') AS UNSIGNED) >= ?", [$minHp]);
        }

        // Transmission Filter
        if ($request->filled('transmission')) {
            $query->where('transmission', 'LIKE', '%' . $request->transmission . '%');
        }

        $sort = $request->get('sort', 'newest');
        if ($sort == 'fastest') {
            $query->orderBy('top_speed', 'desc');
        } elseif ($sort == 'best') {
            $query->orderBy('data_completion', 'desc');
        } else {
            $query->orderBy('year', 'desc')->latest();
        }

        $cars = $query->get();

        // Fetch dynamic options for filters
        $brands = Car::where('status', 'Live')->distinct()->pluck('make')->sort();
        $categories = Car::where('status', 'Live')->whereNotNull('category')->distinct()->pluck('category')->sort();
        $transmissions = ['Manual', 'Automatic', 'PDK', 'Dual-Clutch', 'Sequential'];

        return view('welcome', compact('cars', 'brands', 'categories', 'transmissions'));
    }

    public function brands()
    {
        $brands = Car::where('status', 'Live')
            ->select('make', DB::raw('count(*) as total'), DB::raw('MAX(image_url) as image'))
            ->groupBy('make')
            ->get();
        return view('brands.index', compact('brands'));
    }

    public function categories()
    {
        $categories = Car::where('status', 'Live')
            ->whereNotNull('category')
            ->select('category', DB::raw('count(*) as total'), DB::raw('MAX(image_url) as image'))
            ->groupBy('category')
            ->get();
        return view('categories.index', compact('categories'));
    }

    public function show(string $model_id)
    {
        $car = Car::where('model_id', $model_id)->firstOrFail();
        $rivals = Car::where('model_id', '!=', $model_id)->limit(2)->get();
        return view('cars.show', compact('car', 'rivals'));
    }

    public function dashboard(Request $request)
    {
        $query = Car::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('model_id', 'LIKE', "%{$search}%");
            });
        }

        $cars = $query->get();
        $stats = [
            'total' => Car::count(),
            'completion' => Car::avg('data_completion') ?? 0,
        ];
        return view('dashboard', compact('cars', 'stats'));
    }

    public function toggleStatus(Car $car)
    {
        $car->update([
            'status' => $car->status == 'Live' ? 'Draft' : 'Live'
        ]);
        return back()->with('success', 'Status updated for ' . $car->model_id);
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
        $hp = array_filter([$request->hp_primary, $request->hp_secondary]);
        $gallery = array_filter([$request->gallery_1, $request->gallery_2, $request->gallery_3]);

        $car = Car::create($validated + [
            'pros' => array_filter($pros),
            'cons' => array_filter($cons),
            'engine' => $engine,
            'hp' => $hp,
            'gallery' => $gallery,
        ]);

        $car->update(['data_completion' => $this->calculateCompletion($car)]);

        return redirect()->route('dashboard')->with('success', 'Asset deployed successfully.');
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function duplicate(Car $car)
    {
        // Replicate the car but remove unique model_id
        $newCar = $car->replicate();
        $newCar->model_id = $car->model_id . '-COPY';
        
        return view('cars.create', ['duplicate' => $newCar]);
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|string',
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
        $hp = array_filter([$request->hp_primary, $request->hp_secondary]);
        $gallery = array_filter([$request->gallery_1, $request->gallery_2, $request->gallery_3]);

        $car->update($validated + [
            'pros' => array_filter($pros),
            'cons' => array_filter($cons),
            'engine' => $engine,
            'hp' => $hp,
            'gallery' => $gallery,
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
