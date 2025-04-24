<?php

use App\Http\Controllers\ConfectioneryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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


// Página de marketplace não precisa de login
// Exibir confeiterias
Route::get("/confectioneries", [ConfectioneryController::class, 'index'])->name("confectionery.index");
Route::get("/confectionery/{id}", [ConfectioneryController::class, 'show'])->name("confectionery.show");

// Rotas do marketplace que precisam de login
Route::middleware("auth")->group(function() {

    // Registrar confeitaria
    Route::get("/confectionery/create", function(){ 
        return Inertia::render("Confectionery/RegisterConfectionery"); 
    })->name("confectionery.create");
    Route::post("/confectionery/create", [ConfectioneryController::class, "store"])->name("confectionery.store");

    // Editar Confeitaria
    Route::get("/confectionery/update/{id}", [ConfectioneryController::class, 'edit'])->name("confectionery.edit");
    Route::patch("/confectionery/update/{id}", [ConfectioneryController::class, 'update'])->name("confectionery.update");

    // Deletar Confeitaria
    Route::delete("/confectionery/delete/{id}", [ConfectioneryController::class, 'destroy'])->name("confectionery.destroy");
});


// Rotas de produtos que não precisam de login
// Ver produtos
Route::get("/confectionery/{confectioneryId}/product/{productId}", [ProductController::class, "show"])->name("product.show");

// Rotas relacionadas aos produtos
Route::middleware("auth")->group(function(){

    // Criar produto
    Route::get("/confectionery/{confectioneryId}/product/create", [ProductController::class, "create"])->name("product.create");
    Route::post("/confectionery/{confectioneryId}/product/create", [ProductController::class, "store"])->name("product.store");

});


// Rotas relacionadas ao usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
