<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarController;
use App\Http\Controllers\CommentController;

Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/compare', [CarController::class, 'compare'])->name('compare');
Route::get('/brands', [CarController::class, 'brands'])->name('brands');
Route::get('/categories', [CarController::class, 'categories'])->name('categories');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');
    Route::get('/cars/{car}/duplicate', [CarController::class, 'duplicate'])->name('cars.duplicate');
    Route::post('/cars/{car}/toggle-status', [CarController::class, 'toggleStatus'])->name('cars.toggle-status');
    Route::resource('cars', CarController::class)->except(['index', 'show']);

    // Brand Management
    Route::get('/admin/brands', [\App\Http\Controllers\BrandController::class, 'index'])->name('admin.brands.index');
    Route::post('/admin/brands', [\App\Http\Controllers\BrandController::class, 'store'])->name('admin.brands.store');
    Route::delete('/admin/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'destroy'])->name('admin.brands.destroy');
    Route::post('/admin/brands/sync', [\App\Http\Controllers\BrandController::class, 'syncFromCars'])->name('admin.brands.sync');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Comments
    Route::post('/cars/{car}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Favorites
    Route::post('/cars/{car}/favorite', [CarController::class, 'toggleFavorite'])->name('cars.favorite');
    Route::get('/favorites', [CarController::class, 'favorites'])->name('favorites.index');

    // Ratings
    Route::post('/cars/{car}/rate', [CarController::class, 'rate'])->name('cars.rate');
});

require __DIR__.'/auth.php';

Route::get('/{car}', [CarController::class, 'show'])->name('cars.show');
