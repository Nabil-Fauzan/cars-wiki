<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CarController extends Controller
{
    use AuthorizesRequests;

    protected CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $query = Car::with('brands')->where('status', 'Live');
        
        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model', 'LIKE', "%{$search}%")
                  ->orWhereHas('brands', function($bq) use ($search) {
                      $bq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Brand Filter (Updated for Many-to-Many)
        if ($request->filled('brand')) {
            $query->whereHas('brands', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Horsepower Filter (Optimized)
        if ($request->filled('hp')) {
            $minHp = (int) str_replace('+', '', $request->hp);
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

        // Calculate dynamic stats for the Encyclopedia Framework
        $totalCars = Car::where('status', 'Live')->count();
        $dailyCount = Car::where('status', 'Live')->where('created_at', '>=', now()->subDay())->count();
        $averageCompletion = Car::where('status', 'Live')->avg('data_completion') ?? 0;

        // Use the Brand model instead of distinct column
        $brands = Brand::has('cars')->orderBy('name')->get();
        $categories = Car::where('status', 'Live')->whereNotNull('category')->distinct()->pluck('category')->sort();
        $transmissions = ['Manual', 'Automatic', 'PDK', 'Dual-Clutch', 'Sequential'];

        return view('welcome', compact('cars', 'brands', 'categories', 'transmissions', 'totalCars', 'dailyCount', 'averageCompletion'));
    }

    public function brands()
    {
        $brands = Brand::with(['cars' => function($q) {
                $q->where('status', 'Live')->select('cars.id', 'image_url')->limit(1);
            }])
            ->withCount('cars')
            ->orderBy('name')
            ->get();
        return view('brands.index', compact('brands'));
    }

    public function categories()
    {
        $categories = Car::where('status', 'Live')
            ->whereNotNull('category')
            ->select('category', DB::raw('count(*) as total'), DB::raw('MAX(image_url) as image'))
            ->groupBy('category')
            ->orderBy('category')
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
        $this->authorize('viewAny', Car::class);

        $query = Car::with('brands')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model', 'LIKE', "%{$search}%")
                  ->orWhere('model_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('brands', function($bq) use ($search) {
                      $bq->where('name', 'LIKE', "%{$search}%");
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

    public function toggleStatus(Car $car)
    {
        $this->authorize('update', $car);

        $car->update([
            'status' => $car->status == 'Live' ? 'Draft' : 'Live'
        ]);
        return back()->with('success', 'Status updated for ' . $car->model_id);
    }

    public function compare(Request $request)
    {
        $car1 = $request->has('car1') ? Car::with('brands')->where('model_id', $request->car1)->first() : null;
        $car2 = $request->has('car2') ? Car::with('brands')->where('model_id', $request->car2)->first() : null;

        if (!$car1 && !$car2) {
            $defaultCars = Car::with('brands')->where('status', 'Live')->limit(2)->get();
            $car1 = $defaultCars[0] ?? null;
            $car2 = $defaultCars[1] ?? null;
        }

        $allCars = Car::with('brands')->where('status', 'Live')->orderBy('model')->get();

        return view('compare.index', compact('car1', 'car2', 'allCars'));
    }

    public function create()
    {
        $this->authorize('create', Car::class);
        $brands = Brand::orderBy('name')->get();
        $categories = Car::distinct()->pluck('category')->filter()->sort();
        return view('cars.create', compact('brands', 'categories'));
    }

    public function store(StoreCarRequest $request)
    {
        $this->authorize('create', Car::class);
        
        $this->carService->create($request->validated(), $request);

        return redirect()->route('dashboard')->with('success', 'Asset deployed successfully.');
    }

    public function edit(Car $car)
    {
        $this->authorize('update', $car);
        $brands = Brand::orderBy('name')->get();
        $categories = Car::distinct()->pluck('category')->filter()->sort();
        return view('cars.edit', compact('car', 'brands', 'categories'));
    }

    public function duplicate(Car $car)
    {
        $this->authorize('duplicate', $car);

        $newCar = $car->replicate();
        $newCar->model_id = $car->model_id . '-COPY';
        $newCar->setRelation('brands', $car->brands);
        
        $brands = Brand::orderBy('name')->get();
        $categories = Car::distinct()->pluck('category')->filter()->sort();
        return view('cars.create', ['duplicate' => $newCar, 'brands' => $brands, 'categories' => $categories]);
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $this->authorize('update', $car);

        $this->carService->update($car, $request->validated(), $request);

        return redirect()->route('dashboard')->with('success', 'Asset synchronized successfully.');
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        $car->delete();
        return redirect()->route('dashboard')->with('success', 'Asset decommissioned.');
    }
}
