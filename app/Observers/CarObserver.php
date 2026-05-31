<?php

namespace App\Observers;

use App\Models\Car;
use App\Services\CarService;

class CarObserver
{
    protected CarService $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Handle the Car "saving" event.
     * This runs before create and update.
     */
    public function saving(Car $car): void
    {
        // Price integrity check
        if ($car->min_price > $car->max_price) {
            $temp = $car->min_price;
            $car->min_price = $car->max_price;
            $car->max_price = $temp;
        }

        $car->seo_score = $car->calculateSeoScore();
        $car->data_completion = $car->calculateDataCompletion();
    }
}
