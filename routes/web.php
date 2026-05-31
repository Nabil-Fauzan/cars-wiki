<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\CarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContributionController;

Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::get('/brands', [BrandController::class, 'publicIndex'])->name('brands');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/about', function () {
    return view('about', [
        'carCount' => \App\Models\Car::count()
    ]);
})->name('about');

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/contribution-guidelines', function () {
    return view('contribution');
})->name('contribution');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/garage', [GarageController::class, 'index'])->name('garage');
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
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::post('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Comments
    Route::post('/cars/{car}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Favorites
    Route::post('/cars/{car}/favorite', [GarageController::class, 'toggleFavorite'])->name('cars.favorite');
    Route::get('/favorites', [GarageController::class, 'favorites'])->name('favorites.index');

    // Ratings
    Route::post('/cars/{car}/rate', [GarageController::class, 'rate'])->name('cars.rate');

    // Personal Notes
    Route::post('/cars/{car}/notes', [GarageController::class, 'savePersonalNote'])->name('cars.notes.save');

    // Comparison Sets
    Route::post('/compare/save', [CompareController::class, 'save'])->name('compare.save');

    // Contribution Suggestions
    Route::post('/cars/{car}/suggest', [ContributionController::class, 'suggestRevision'])->name('cars.suggest');
});

require __DIR__.'/auth.php';

Route::get('/{car}', [CarController::class, 'show'])->name('cars.show');
