<?php

namespace App\Livewire\Store\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.store')]
class Login extends Component
{
    public function render()
    {
        return view('livewire.store.auth.login');
    }
}
