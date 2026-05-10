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
        $car->data_completion = $this->carService->calculateCompletion($car);
    }
}
