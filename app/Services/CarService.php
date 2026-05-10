<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Http\Request;

class CarService
{
    public function prepareData(array $data, Request $request): array
    {
        $pros = $request->pros ? explode("\n", str_replace("\r", "", $request->pros)) : [];
        $cons = $request->cons ? explode("\n", str_replace("\r", "", $request->cons)) : [];
        $engine = array_filter([$request->engine_primary, $request->engine_secondary]);
        $hp = array_filter([$request->hp_primary, $request->hp_secondary]);
        $gallery = array_filter([$request->gallery_1, $request->gallery_2, $request->gallery_3]);

        return array_merge($data, [
            'pros' => array_filter($pros),
            'cons' => array_filter($cons),
            'engine' => $engine,
            'hp' => $hp,
            'gallery' => $gallery,
        ]);
    }

    public function create(array $validatedData, Request $request): Car
    {
        // Exclude brand_ids from the main car data
        $carData = \Illuminate\Support\Arr::except($validatedData, ['brand_ids']);
        $data = $this->prepareData($carData, $request);
        
        $car = Car::create($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        return $car;
    }

    public function update(Car $car, array $validatedData, Request $request): bool
    {
        // Exclude brand_ids from the main car data
        $carData = \Illuminate\Support\Arr::except($validatedData, ['brand_ids']);
        $data = $this->prepareData($carData, $request);
        
        $updated = $car->update($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        } else {
            $car->brands()->detach();
        }

        return $updated;
    }

    public function calculateCompletion(Car $car): int
    {
        $fields = [
            'model', 'year', 'category', 'image_url', 
            'zero_to_sixty', 'top_speed', 'history', 
            'torque', 'transmission', 'drivetrain'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($car->$field)) $filled++;
        }

        if (!empty($car->pros)) $filled++;
        if (!empty($car->cons)) $filled++;
        if (!empty($car->engine)) $filled++;
        if (!empty($car->gallery)) $filled++;

        return round(($filled / (count($fields) + 4)) * 100);
    }
}
