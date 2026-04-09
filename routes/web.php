<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;

// ─────────────────────────────────────────────────────────────────────────────
// PAGE DE CONNEXION (publique)
// La route GET '/' affiche la page de login personnalisée.
// ─────────────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ─────────────────────────────────────────────────────────────────────────────
// DÉSACTIVATION DU FORMULAIRE D'INSCRIPTION
// Conformément aux specs, l'inscription libre est DÉSACTIVÉE :
//   - GET  /register → redirigé vers la page de connexion
//   - POST /register → redirigé vers la page de connexion
// Fortify déclare ces routes en interne ; on les court-circuite ici.
// ─────────────────────────────────────────────────────────────────────────────
Route::get('/register', fn() => redirect()->route('login')
    ->with('info', 'L\'inscription est désactivée. Contactez restauration@enc-bessieres.org.')
)->name('register');

Route::post('/register', fn() => redirect()->route('login'));

// ─────────────────────────────────────────────────────────────────────────────
// ROUTES PROTÉGÉES (utilisateurs authentifiés)
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Tableau de bord
    Route::get('/dashboard', function () {
        $prochaines = \App\Models\Reservation::where('user_id', auth()->id())
            ->where('date', '>=', today())
            ->orderBy('date')
            ->take(5)
            ->get();
        return view('dashboard', compact('prochaines'));
    })->name('dashboard');

    // Menu de la semaine
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.semaine');

    // Réservations
    Route::get('/reservations',  [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // ─── ROUTES RÉSERVÉES AUX ADMINISTRATEURS ────────────────────────────────
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/utilisateurs',          [AdminController::class, 'index'])->name('users.index');
        Route::post('/utilisateurs',         [AdminController::class, 'store'])->name('users.store');
        Route::patch('/utilisateurs/{user}/admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
        Route::delete('/utilisateurs/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    });
});
