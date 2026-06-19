<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view(
            'livewire.admin.categories.index',
            ['categories' => Category::with('parent')->with('products')->paginate(10)]
        );
    }
}
