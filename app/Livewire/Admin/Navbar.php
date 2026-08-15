<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Services\Search\GlobalSearchService;

class Navbar extends Component
{

    // Search Variables
    public string $searchQuery = '';
    public array $searchResults = [];

    // Execute Search Operation
    public function updateSearchQuery(GlobalSearchService $searchService)
    {
        $this->searchResults = $searchService->search($this->searchQuery);
    }

    public function render()
    {

        return view('livewire.admin.navbar');

    }

}
