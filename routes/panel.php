<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\Index;
use App\Livewire\Admin\Categories\Create;

Route::get('/panel', function () {
    return 'Welcome to control panel';
});

Route::get('/panel/login', function () {
    return 'Welcome to control panel login';
})->name('panel.login');

// Categories pages
Route::livewire('panel/categories', Index::class)->name('panel.category'); // Show Categories and SubCategories to Manage them

Route::livewire('panel/categories/create', Create::class)->name('panel.category.create'); // Add new Categories