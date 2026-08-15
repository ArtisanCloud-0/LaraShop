<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;
use App\Livewire\Store\Product;
use App\Livewire\Store\ProductDetails;

use App\Livewire\Checkout\Index As Checkout;
use App\Livewire\Checkout\OrderSuccess;

Route::get('/login', function() {
    //
})->name('login');

// Homepage Route
Route::get('/', Welcome::class)->name('home');

// Cart Bag Route
Route::get('/cart', Cart::class)->name('cart');

// Checkout & Order Success Routes
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/order/success/{orderId}', OrderSuccess::class)->name('order.success');

// Products Main Page
Route::get('/product', Product::class)->name('products');

// Product Details Page
Route::get('/product/{product:slug}', ProductDetails::class)->name('product.details');
