<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecetteController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home'); // Ajout d'un nom pour faciliter les redirections

/*
|--------------------------------------------------------------------------
| Routes Protégées (Authentification + Email vérifié)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/recettes/{recette}/edit', [RecetteController::class, 'edit'])->name('recettes.edit');
        Route::put('/recettes/{recette}', [RecetteController::class, 'update'])->name('recettes.update');
        Route::get('/recettes/{id}/edit', [RecetteController::class, 'edit'])->name('recettes.edit');
        Route::delete('/recettes/{id}', [RecetteController::class, 'destroy'])->name('recettes.destroy');
        Route::get('/recettes/create', [RecetteController::class, 'create'])->name('recettes.create');
        Route::post('/recettes', [RecetteController::class, 'store'])->name('recettes.store');
    });

    // Recettes
    Route::resource('recettes', RecetteController::class)
         ->names('recettes');
});

/*
|--------------------------------------------------------------------------
| Authentification (login, register, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
