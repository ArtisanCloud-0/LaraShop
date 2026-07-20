<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Store\Welcome;

Route::livewire('/', Welcome::class)->name('home');
