<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $query = Car::with('brands')->where('status', 'Live')->where('moderation_status', 'published');
        
        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model', 'LIKE', "%{$search}%")
                  ->orWhere('model_id', 'LIKE', "%{$search}%")
                  ->orWhere('year', 'LIKE', "%{$search}%")
                  ->orWhereHas('brands', function($bq) use ($search) {
                      $bq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Brand Filter (Updated for Many-to-Many)
        if ($request->filled('brand')) {
            $query->whereHas('brands', function($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Year Range Filter (Handles ranges like 1984-1989)
        if ($request->filled('year_min')) {
            $query->whereRaw("CAST(SUBSTRING_INDEX(year, '-', 1) AS UNSIGNED) >= ?", [$request->year_min]);
        }
        if ($request->filled('year_max')) {
            $query->whereRaw("CAST(SUBSTRING_INDEX(year, '-', 1) AS UNSIGNED) <= ?", [$request->year_max]);
        }

        // Horsepower Filter (Optimized)
        if ($request->filled('hp')) {
            $minHp = (int) str_replace('+', '', $request->hp);
            // Since hp is stored as JSON array like ["400 hp", "450 hp"], we extract the first one
            $query->whereRaw("CAST(REGEXP_REPLACE(JSON_UNQUOTE(JSON_EXTRACT(hp, '$[0]')), '[^0-9]', '') AS UNSIGNED) >= ?", [$minHp]);
        }

        // Transmission Filter
        if ($request->filled('transmission')) {
            $query->where('transmission', 'LIKE', '%' . $request->transmission . '%');
        }

        // Performance Filters
        if ($request->filled('top_speed_min')) {
            $query->where('top_speed', '>=', $request->top_speed_min);
        }

        $sort = $request->get('sort', 'newest');
        if ($sort == 'fastest') {
            $query->orderBy('top_speed', 'desc');
        } elseif ($sort == 'best') {
            $query->orderBy('data_completion', 'desc');
        } elseif ($sort == 'acceleration') {
            $query->orderBy('zero_to_sixty', 'asc');
        } else {
            $query->orderBy('year', 'desc')->latest();
        }

        $cars = $query->paginate(12)->withQueryString();

        // Calculate dynamic stats for the Encyclopedia Framework
        $totalCars = Car::where('status', 'Live')->count();
        $dailyCount = Car::where('status', 'Live')->where('created_at', '>=', now()->subDay())->count();
        $averageCompletion = Car::where('status', 'Live')->avg('data_completion') ?? 0;

        $brandModels = Brand::has('cars')->orderBy('name')->get();
        
        $categories = Cache::remember('pcar_categories_list_v2', 3600, function() {
            return Car::where('status', 'Live')->where('moderation_status', 'published')
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category')
                ->filter(fn($c) => is_string($c))
                ->sort();
        });

        $transmissions = ['Manual', 'Automatic', 'PDK', 'Dual-Clutch', 'Sequential'];

        return view('welcome', compact('cars', 'brandModels', 'categories', 'transmissions', 'totalCars', 'dailyCount', 'averageCompletion'));
    }

    public function brands()
    {
        $brands = Brand::with(['cars' => function($q) {
                $q->where('status', 'Live')->where('moderation_status', 'published')->select('cars.id', 'image_url')->limit(1);
            }])
            ->withCount('cars')
            ->orderBy('name')
            ->get();
        return view('brands.index', compact('brands'));
    }

    public function categories()
    {
        $categories = Car::where('status', 'Live')->where('moderation_status', 'published')
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
        
        // Moderation Check: Only published cars are visible to the public.
        // Admin and Editor can view drafts/pending.
        /** @var User $user */
        $user = Auth::user();
        if ($car->moderation_status !== 'published' && (!$user || !$user->hasAnyRole(['admin', 'editor']))) {
            abort(403, 'This specimen is currently under classification and not yet public.');
        }

        $ratingStats = $car->ratings()
            ->selectRaw('avg(comfort) as comfort, avg(performance) as performance, avg(design) as design, avg(value) as value')
            ->first();

        $rivals = Car::where('model_id', '!=', $model_id)->limit(2)->get();
        
        $personalNote = null;
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $personalNote = $user->personalNotes()->where('car_id', $model_id)->first();
        }

        return view('cars.show', compact('car', 'rivals', 'ratingStats', 'personalNote'));
    }

    public function garage()
    {
        /** @var User $user */
        $user = Auth::user();
        $favorites = $user->favorites()->with('brands')->get();
        $comparisonSets = $user->comparisonSets()->with(['car1.brands', 'car2.brands', 'car3.brands'])->latest()->get();
        $personalNotes = $user->personalNotes()->with('car.brands')->latest()->get();

        return view('profile.garage', compact('favorites', 'comparisonSets', 'personalNotes'));
    }

    public function dashboard(Request $request)
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
        $car3 = $request->has('car3') ? Car::with('brands')->where('model_id', $request->car3)->first() : null;

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

        // Log Comparison for Heatmap
        if ($car1 && $car2) {
            \App\Models\ComparisonLog::create(['car_a_id' => $car1->id, 'car_b_id' => $car2->id]);
            $car1->increment('comparison_count');
            $car2->increment('comparison_count');
        }
        if ($car2 && $car3) {
            \App\Models\ComparisonLog::create(['car_a_id' => $car2->id, 'car_b_id' => $car3->id]);
            $car2->increment('comparison_count');
            $car3->increment('comparison_count');
        }
        if ($car1 && $car3) {
            \App\Models\ComparisonLog::create(['car_a_id' => $car1->id, 'car_b_id' => $car3->id]);
            $car1->increment('comparison_count');
            $car3->increment('comparison_count');
        }

        $allCars = Car::with('brands')->where('status', 'Live')->orderBy('model')->get();

        $differences = [];
        $cars = array_filter([$car1, $car2, $car3]);
        
        if (count($cars) >= 2) {
            $metrics = [
                'category', 'year', 'hp', 'torque', 'engine', 'transmission', 'drivetrain', 
                'zero_to_sixty', 'top_speed', 'aerodynamics', 'braking', 'brands'
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
        $newCar->model_id = $car->model_id . '-COPY-' . strtoupper(\Illuminate\Support\Str::random(3));
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

    public function toggleFavorite(Car $car)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->favorites()->toggle($car->id);
        
        return back()->with('success', 'Wishlist updated.');
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

    public function saveComparisonSet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'car1_id' => 'required|string',
            'car2_id' => 'required|string',
            'car3_id' => 'nullable|string',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->comparisonSets()->create($request->all());

        return back()->with('success', 'Battle Set saved to your Garage.');
    }

    public function savePersonalNote(Request $request, Car $car)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->personalNotes()->updateOrCreate(
            ['car_id' => $car->model_id],
            ['content' => $request->content]
        );

        return back()->with('success', 'Personal note updated.');
    }
}
