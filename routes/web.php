<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/info', function () {
    return view('pages/info-user_cantine');
}) -> name('info');

Route::get( '/dashboard', function () {
    return view('dashboard');
}) -> name('dashboard');

Route::get( '/creation-etudiant', function () {
    return view('pages/creation-etudiant');
}) -> name('creation-etudiant');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');



