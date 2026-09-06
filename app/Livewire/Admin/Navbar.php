<?php

namespace App\Livewire\Admin;

use App\Services\Search\GlobalSearchService;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Search State
    |--------------------------------------------------------------------------
    */

    public string $searchQuery = '';

    public array $searchResults = [
        'products' => [],
        'orders'   => [],
        'users'    => [],
    ];

    /*
    |--------------------------------------------------------------------------
    | Search Handler
    |--------------------------------------------------------------------------
    |
    | Livewire automatically calls this method whenever the
    | $searchQuery property is updated.
    |
    */

    public function updatedSearchQuery(): void
    {
        $this->searchResults = resolve(GlobalSearchService::class)->search($this->searchQuery);
    }

    #[On('profile-updated')]
    public function refreshNavigation()
    {
        // Re-renders navigation component automatically to display fresh user image/info
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.admin.navbar');
    }
}
