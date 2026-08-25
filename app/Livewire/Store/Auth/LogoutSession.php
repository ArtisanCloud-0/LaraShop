<?php

namespace App\Livewire\Store\Auth;

use App\Actions\Auth\LogoutUserAction;
use Livewire\Component;

class LogoutSession extends Component
{

    public function mount()
    {
        $this->logout();
    }

    public function logout()
    {
        // Execute logout for the admin guard
        resolve(LogoutUserAction::class)->execute();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.store.auth.logout-session');
    }
}
