<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\CarController;
use App\Http\Controllers\CommentController;

Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/compare', [CarController::class, 'compare'])->name('compare');
Route::get('/brands', [CarController::class, 'brands'])->name('brands');
Route::get('/categories', [CarController::class, 'categories'])->name('categories');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');
    Route::get('/garage', [CarController::class, 'garage'])->name('garage');
    Route::get('/cars/{car}/duplicate', [CarController::class, 'duplicate'])->name('cars.duplicate');
    Route::post('/cars/{car}/toggle-status', [CarController::class, 'toggleStatus'])->name('cars.toggle-status');
    Route::resource('cars', CarController::class)->except(['index', 'show']);

    // Brand Management
    Route::get('/admin/brands', [\App\Http\Controllers\BrandController::class, 'index'])->name('admin.brands.index');
    Route::post('/admin/brands', [\App\Http\Controllers\BrandController::class, 'store'])->name('admin.brands.store');
    Route::delete('/admin/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'destroy'])->name('admin.brands.destroy');
    Route::post('/admin/brands/sync', [\App\Http\Controllers\BrandController::class, 'syncFromCars'])->name('admin.brands.sync');

    // AI Content Generation
    Route::post('/admin/ai/generate', [\App\Http\Controllers\Admin\CarAiController::class, 'generate'])->name('admin.ai.generate');
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

    // Personal Notes
    Route::post('/cars/{car}/notes', [CarController::class, 'savePersonalNote'])->name('cars.notes.save');

    // Comparison Sets
    Route::post('/compare/save', [CarController::class, 'saveComparisonSet'])->name('compare.save');
});

require __DIR__.'/auth.php';

Route::get('/{car}', [CarController::class, 'show'])->name('cars.show');
