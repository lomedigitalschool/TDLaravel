<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Route vers la page d'accueil (redirige vers le tableau de bord)


Route::get('/', function () {
    return view('home'); // Vue publique non protégée
})->name('home');


// Tableau de bord : liste les todos de l'utilisateur connecté
Route::get('/dashboard', [TodoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('index');


// Routes protégées pour utilisateur authentifié
Route::middleware('auth')->group(function () {
    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD des tâches (todos)
    Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

    // Marquer une tâche comme complétée (optionnel)
    Route::patch('/todos/{todo}/complete', [TodoController::class, 'markAsCompleted'])->name('todos.complete');

    // Recherche de tâches (optionnel)
    Route::get('/search', [TodoController::class, 'search'])->name('todos.search');
});

require __DIR__.'/auth.php';
