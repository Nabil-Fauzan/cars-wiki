<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('cars')->orderBy('name')->get();
        return view('brands.admin', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'New brand added to the registry.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with('success', 'Brand decommissioned.');
    }

    /**
     * Automatic migration from Car 'make' column
     */
    public function syncFromCars()
    {
        $makes = Car::distinct()->pluck('make');
        $count = 0;

        foreach($makes as $make) {
            if ($make) {
                $brand = Brand::firstOrCreate(
                    ['name' => $make],
                    ['slug' => Str::slug($make)]
                );
                
                // Link cars that have this make to the brand if not already linked
                $cars = Car::where('make', $make)->get();
                foreach($cars as $car) {
                    $car->brands()->syncWithoutDetaching([$brand->id]);
                }
                $count++;
            }
        }

        return back()->with('success', "Synchronization complete. {$count} brands extracted from car data.");
    }
}
