<?php

use Illuminate\Support\Facades\Route;

// ==============================================================================================================

// Categories
use App\Livewire\Admin\Categories\Index As Categories;
use App\Livewire\Admin\Categories\Create;
use App\Livewire\Admin\Categories\Edit;

// ==============================================================================================================

// Products
use App\Livewire\Admin\Products\Index As Products;
use App\Livewire\Admin\Products\Upsert;
use App\Livewire\Admin\Products\ManageSkus;

// ==============================================================================================================

Route::get('/panel', function () {
    return 'Welcome to control panel';
})->name('panel');

Route::get('/panel/login', function () {
    return 'Welcome to control panel login';
})->name('panel.login');

// ==============================================================================================================

// =================
// Categories pages
// =================

// Show Categories and SubCategories to Manage them
Route::livewire('panel/categories', Categories::class)->name('panel.categories'); 

// Add new Categories
Route::livewire('panel/categories/create', Create::class)->name('panel.categories.create'); 

// Edit Categories
Route::livewire('panel/categories/{category}/edit', Edit::class)->name('panel.categories.edit'); 

// ==============================================================================================================

// ===============
// Products pages
// ===============
// Products View 
Route::livewire('panel/products', Products::class)->name('panel.products');

// Add | Edit Products
Route::livewire('panel/products/upsert', Upsert::class)->name('panel.products.upsert');

Route::livewire('panel/products/{product}/edit', Upsert::class)->name('panel.products.edit');

Route::livewire('panel/products/{product}/skus', ManageSkus::class)->name('panel.products.skus');

// ==============================================================================================================

// =============
// Orders pages
// =============
Route::get('panel/orders', function() {
    //
})->name('panel.orders');

// ==============================================================================================================

// ==============
// Reports pages
// ==============
Route::get('panel/reports', function() {
    //
})->name('panel.reports');

// ==============================================================================================================
