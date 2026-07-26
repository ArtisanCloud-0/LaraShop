<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;
use App\Livewire\Store\Product;
use App\Livewire\Store\ProductDetails;

// Homepage Route
Route::get('/', Welcome::class)->name('home');

// Cart Bag Route
Route::get('/cart', Cart::class)->name('cart');

// Products Main Page
Route::get('/product', Product::class)->name('products');

// Product Details Page
Route::get('/product/{product:slug}', ProductDetails::class)->name('product.details');
