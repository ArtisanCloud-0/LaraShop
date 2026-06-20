<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\Index;
use App\Livewire\Admin\Categories\Create;
use App\Livewire\Admin\Categories\Edit;

Route::get('/panel', function () {
    return 'Welcome to control panel';
})->name('panel');

Route::get('/panel/login', function () {
    return 'Welcome to control panel login';
})->name('panel.login');

// Categories pages
Route::livewire('panel/categories', Index::class)->name('panel.categories'); // Show Categories and SubCategories to Manage them

Route::livewire('panel/categories/create', Create::class)->name('panel.categories.create'); // Add new Categories

Route::livewire('panel/categories/{category}/edit', Edit::class)->name('panel.categories.edit'); // Edit Categories

// Products pages
Route::get('panel/products', function() {
    //
})->name('panel.products');

// Orders pages
Route::get('panel/orders', function() {
    //
})->name('panel.orders');

// Reports pages
Route::get('panel/reports', function() {
    //
})->name('panel.reports');
