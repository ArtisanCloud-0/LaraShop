<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;
use App\Livewire\Store\Product;

// Homepage Route
Route::get('/', Welcome::class)->name('home');

// Cart Bag Route
Route::get('/cart', Cart::class)->name('cart');

// Products Main Page
Route::get('/product', Product::class)->name('products');
