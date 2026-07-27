<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use App\Actions\Auth\LogoutUserAction;

class Logout extends Component
{

    public function mount()
    {
        $this->logout();
    }

    public function logout()
    {
        // Execute logout for the admin guard
        resolve(LogoutUserAction::class)->execute('panel');

        return redirect()->route('panel.login');
    }

    public function render()
    {
        return view('livewire.admin.auth.logout');
    }
}
