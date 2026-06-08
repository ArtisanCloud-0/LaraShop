<?php

use Illuminate\Support\Facades\Route;

Route::get('/panel', function () {
    return 'Welcome to control panel';
});

Route::get('/panel/login', function () {
    return 'Welcome to control panel login';
})->name('panel.login');
