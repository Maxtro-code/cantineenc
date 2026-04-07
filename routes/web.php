<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ CORRECTION PRINCIPALE : La ligne Route::post('/register') a été supprimée.
// Elle écrasait la route de Fortify et empêchait la création des utilisateurs en base de données.
// Fortify gère automatiquement POST /register via CreateNewUser.

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/info', function () {
        return view('pages/info-user_cantine');
    })->name('info');

    Route::get('/creation-etudiant', function () {
        return view('pages/creation-etudiant');
    })->name('creation-etudiant');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});
