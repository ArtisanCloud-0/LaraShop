<?php

namespace App\Livewire\Store;

use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('layouts::store')]
class Welcome extends Component
{
    public function render()
    {
        return view('livewire.store.welcome');
    }
}
