<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/read/{slug}', [DashboardController::class, 'detail'])->name('read');

Route::prefix('article')->name('article.')->group(function() {
    Route::get('/create', [ArticleController::class, 'create'])->name('create');
    Route::post('/create', [ArticleController::class, 'store'])->name('store');
    Route::get('/{user}',[ArticleController::class,'index'])->name('index');
})->middleware('auth');

Route::get('/office', [OfficeController::class,'index'])->name('office');
Route::get('/office/create', [OfficeController::class, 'create'])->name('office.create');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
