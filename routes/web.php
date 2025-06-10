<?php
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routes protégées
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD complet des journaux
    Route::resource('journal', JournalEntryController::class);

    // Profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes publiques
Route::get('/public', [JournalEntryController::class, 'publicEntries'])->name('journal.public');
Route::get('/public/{journalEntry}', [JournalEntryController::class, 'show'])->name('journal.public.show');

require __DIR__.'/auth.php';
