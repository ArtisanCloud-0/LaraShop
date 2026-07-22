<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;
use App\Livewire\Store\Cart;

Route::get('/', Welcome::class)->name('home');

Route::get('/cart', Cart::class)->name('cart');
