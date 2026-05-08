<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarController;

Route::get('/', [CarController::class, 'index'])->name('home');

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::get('/brands', [CarController::class, 'brands'])->name('brands');

Route::get('/compare', [CarController::class, 'compare'])->name('compare');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');
    Route::resource('cars', CarController::class)->except(['index', 'show']);
});

Route::get('/cars/{model_id}', [CarController::class, 'show'])->name('cars.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
