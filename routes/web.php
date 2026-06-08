<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Welcome to Homepage';
})->middleware('auth');

Route::get('/login', function () {
    return 'Welcome to Homepage Login';
})->name('login');
