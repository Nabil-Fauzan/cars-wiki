<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarService
{
    public function prepareData(array $data, Request $request): array
    {
        // Sanitize prices (remove commas, plus signs, and other non-numeric chars except decimal)
        if (isset($data['min_price'])) {
            $data['min_price'] = (float) preg_replace('/[^0-9.]/', '', $data['min_price']);
        }
        if (isset($data['max_price'])) {
            $data['max_price'] = (float) preg_replace('/[^0-9.]/', '', $data['max_price']);
        }
        if (isset($data['avg_price'])) {
            $data['avg_price'] = (float) preg_replace('/[^0-9.]/', '', $data['avg_price']);
        }

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

        $avgPrice = $data['avg_price'] ?? null;
        if (!$avgPrice && isset($data['min_price']) && isset($data['max_price'])) {
            $avgPrice = ($data['min_price'] + $data['max_price']) / 2;
        }

        return array_merge($data, [
            'pros' => array_filter($pros ?? []),
            'cons' => array_filter($cons ?? []),
            'engine' => $engine,
            'hp' => $hp,
            'gallery' => $gallery,
            'avg_price' => $avgPrice,
        ]);
    }

    public function create(array $validatedData, Request $request): Car
    {
        $carData = \Illuminate\Support\Arr::except($validatedData, ['make', 'brand_ids', 'hp_primary', 'hp_secondary', 'engine_primary', 'engine_secondary', 'gallery_1', 'gallery_2', 'gallery_3']);
        $data = $this->prepareData($carData, $request);
        
        $car = Car::create($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        // data_completion is now handled by model saving event, but we can force it here if needed
        // $car->update(['data_completion' => $car->calculateDataCompletion()]);

        Cache::forget('pcar_brand_models_list');
        Cache::forget('pcar_categories_list_v2');

        return $car;
    }

    public function update(Car $car, array $validatedData, Request $request): bool
    {
        $carData = \Illuminate\Support\Arr::except($validatedData, ['make', 'brand_ids', 'hp_primary', 'hp_secondary', 'engine_primary', 'engine_secondary', 'gallery_1', 'gallery_2', 'gallery_3']);
        $data = $this->prepareData($carData, $request);
        
        $updated = $car->update($data);

        if ($request->has('brand_ids')) {
            $car->brands()->sync($request->brand_ids);
        }

        // data_completion is now handled by model saving event
        // $car->save(); // Trigger saving event again if brands changed

        Cache::forget('pcar_brand_models_list');
        Cache::forget('pcar_categories_list_v2');

        return $updated;
    }
}
