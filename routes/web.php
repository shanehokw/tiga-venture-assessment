<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('task')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::post('/', [TaskController::class, 'store'])->name('task.store');
        Route::get('/create', [TaskController::class, 'create'])->name('task.create');
        Route::get('/{id}', [TaskController::class, 'show'])->name('task.show');
        Route::put('/{id}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    });
});

require __DIR__ . '/auth.php';
