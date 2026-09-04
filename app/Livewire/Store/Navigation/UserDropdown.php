<?php

namespace App\Livewire\Store\Navigation;

use Livewire\Component;
use Livewire\Attributes\On;

class UserDropdown extends Component
{
    public bool $isMobile = false;

    public function mount(bool $isMobile = false)
    {
        $this->isMobile = $isMobile;
    }

    #[On('profile-updated')]
    public function refreshUser()
    {
        // Re-renders the component on profile update event
    }

    public function render()
    {
        return view('livewire.store.navigation.user-dropdown', [
            'user' => auth()->user(),
        ]);
    }
}
