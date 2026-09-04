<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;
use App\Livewire\Store\Product;
use App\Livewire\Store\ProductDetails;

use App\Livewire\Checkout\Index as Checkout;
use App\Livewire\Checkout\OrderSuccess;
use App\Livewire\Store\About;
use App\Livewire\Store\Auth\Reg;
use App\Livewire\Store\Auth\Login;
use App\Livewire\Store\Auth\LogoutSession;
use App\Livewire\Store\Profile;
use App\Livewire\Store\ShowOrders;

// Login to store
Route::get('/login', Login::class)->name('login');

// Logout to store
Route::get('/logout', LogoutSession::class)->name('logout');

// Reset Password
Route::get('/reset', function () {})->name('reset.password');

// Create new Larashop account
Route::get('/register', Reg::class)->name('register');

// Homepage Route
Route::get('/', Welcome::class)->name('home');

// About Route
Route::get('/about', About::class)->name('about');

// Cart Bag Route
Route::get('/cart', Cart::class)->name('cart');

// Checkout & Order Success Routes
Route::get('/checkout', Checkout::class)->name('checkout');

// Order Success Route
Route::get('/order/success/{orderNumber}/{publicToken}', OrderSuccess::class)
    ->name('order.success');

// Products Main Page
Route::get('/product', Product::class)->name('products');

// Product Details Page
Route::get('/product/{product:slug}', ProductDetails::class)->name('product.details');

// Show Orders Page
Route::get('/showOrders', ShowOrders::class)->name('show.orders');

// Profile Page
Route::get('/profile', Profile::class)->name('customer.profile');
