<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;
use App\Livewire\Store\Product;
use App\Livewire\Store\ProductDetails;

use App\Livewire\Checkout\Index as Checkout;
use App\Livewire\Checkout\OrderSuccess;

use App\Livewire\Store\Auth\Reg;
use App\Livewire\Store\Auth\Login;

// Login to store
Route::get('/login', Login::class)->name('login');

// Reset Password
Route::get('/reset', function () {})->name('reset.password');

// Create new Larashop account
Route::get('/register', Reg::class)->name('register');

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
