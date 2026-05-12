<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarService
{
    public function prepareData(array $data, Request $request): array
    {
        $pros = $request->pros;
        if (is_string($pros)) {
            $pros = explode("\n", str_replace("\r", "", $pros));
        }
        
        $cons = $request->cons;
        if (is_string($cons)) {
            $cons = explode("\n", str_replace("\r", "", $cons));
        }

        $engine = array_filter([$request->engine_primary, $request->engine_secondary]);
        $hp = array_filter([$request->hp_primary, $request->hp_secondary]);
        $gallery = array_filter([$request->gallery_1, $request->gallery_2, $request->gallery_3]);

        return array_merge($data, [
            'pros' => array_filter($pros ?? []),
            'cons' => array_filter($cons ?? []),
            'engine' => $engine,
            'hp' => $hp,
            'gallery' => $gallery,
        ]);
    }

    public function create(array $validatedData, Request $request): Car
    {
        $carData = \Illuminate\Support\Arr::except($validatedData, ['brand_ids', 'hp_primary', 'hp_secondary', 'engine_primary', 'engine_secondary', 'gallery_1', 'gallery_2', 'gallery_3']);
        $data = $this->prepareData($carData, $request);
        
        $car = Car::create($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        $car->update(['data_completion' => $this->calculateCompletion($car)]);

        Cache::forget('pcar_brand_models_list');
        Cache::forget('pcar_categories_list_v2');

        return $car;
    }

    public function update(Car $car, array $validatedData, Request $request): bool
    {
        $carData = \Illuminate\Support\Arr::except($validatedData, ['brand_ids', 'hp_primary', 'hp_secondary', 'engine_primary', 'engine_secondary', 'gallery_1', 'gallery_2', 'gallery_3']);
        $data = $this->prepareData($carData, $request);
        
        $updated = $car->update($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        $car->update(['data_completion' => $this->calculateCompletion($car)]);

        Cache::forget('pcar_brand_models_list');
        Cache::forget('pcar_categories_list_v2');

        return $updated;
    }

    public function calculateCompletion(Car $car): int
    {
        $fields = [
            'model', 'year', 'category', 'image_url', 
            'zero_to_sixty', 'top_speed', 'history', 
            'torque', 'transmission', 'drivetrain',
            'engine_sound_url', 'min_price', 'max_price', 
            'price_trend', 'marketplace_url'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            $val = $car->$field;
            if (is_numeric($val) || !empty($val)) $filled++;
        }

        $extraChecks = 0;
        if (!empty($car->pros) && count($car->pros) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($car->cons) && count($car->cons) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($car->engine) && count($car->engine) > 0) { $filled++; }
        $extraChecks++;

        if (!empty($car->gallery) && count($car->gallery) > 0) { $filled++; }
        $extraChecks++;

        if ($car->brands()->exists()) { $filled++; }
        $extraChecks++;

        $totalPossible = count($fields) + $extraChecks;

        return round(($filled / $totalPossible) * 100);
    }
}
