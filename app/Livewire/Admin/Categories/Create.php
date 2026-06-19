<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;

use App\Models\Category;

class Create extends Component
{
    public function render()
    {
        return view(
            'livewire.admin.categories.create',
            ['parentCategories' => Category::where('parent_id', '!=', null)->get()]
        );
    }
}
