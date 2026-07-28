<?php

use Illuminate\Support\Facades\Route;

// Dashboard Panel
use App\Livewire\Admin\Dashboard;

// ==============================================================================================================

// Auth
use App\Livewire\Admin\Auth\Login As AdminLogin;
use App\Livewire\Admin\Auth\Logout As AdminLogout;
use App\Livewire\Admin\Auth\AdminUsers;

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

Route::prefix('panel')->middleware('guest:panel')->group(function () {
   
   // Admin Login Route
    Route::get('/login', AdminLogin::class)->name('panel.login');

});

Route::prefix('panel')->middleware(['auth:panel', 'can:access-control-panel'])->group(function () {

    // Admin Logout Route
    Route::post('/logout', AdminLogout::class)->name('panel.logout');

    // Control Panel Dashboard
    Route::get('/', Dashboard::class)->name('dashboard');

    // ==============================================================================================================

    // =======================
    // Create New Admin Users
    // =======================
    Route::get('/users', AdminUsers::class)->name('panel.users');

    // ==============================================================================================================

    // =================
    // Categories pages
    // =================

    // Show Categories and SubCategories to Manage them
    Route::get('/categories', Categories::class)->name('panel.categories'); 

    // Add new Categories
    Route::livewire('categories/create', Create::class)->name('panel.categories.create'); 

    // Edit Categories
    Route::livewire('categories/{category}/edit', Edit::class)->name('panel.categories.edit'); 

    // ==============================================================================================================

    // ===============
    // Products pages
    // ===============
    // Products View 
    Route::livewire('/products', Products::class)->name('panel.products');

    // Add | Edit Products
    Route::livewire('/products/upsert', Upsert::class)->name('panel.products.upsert');

    Route::livewire('/products/{product}/edit', Upsert::class)->name('panel.products.edit');

    // Product Details Management
    Route::livewire('/products/{product}/skus', ManageSkus::class)->name('panel.products.skus');

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

});
