<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/info', function () {
    return view('pages/info-user_cantine');
}) -> name('info');

Route::get( '/dashboard', function () {
    return view('dashboard');
}) -> name('dashboard');

