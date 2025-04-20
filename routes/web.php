<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Confectionery\ConfectioneryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware("auth")->group(function() {
    Route::get("/confectioneries", [ConfectioneryController::class, 'index'])->name("confectionery.index");
    Route::get("/confectionery/create", [ConfectioneryController::class, 'create'])->name("confectionery.create");
    Route::post("/confectionery/create", [ConfectioneryController::class, "store"])->name("confectionery.store");
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
