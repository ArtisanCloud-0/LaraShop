<?php

namespace App\Actions\Category;

use App\Models\Category;

class DeleteCategoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Delete a category only if it is completely empty of dependencies.
     */
    public function execute(Category $category): bool
    {
        
        // [ 1 ] Ensure that the category does't have subcategories
        if($category->children()->exists()):
            session()->flash('error', 'Cannot delete category. It contains nested active subcategories.');
        endif;

        // [ 2 ] Ensure that the category does't have attached products
        if($category->products()->exists()):
            session()->flash('error', 'Cannot delete category. There are active products assigned to this collection.');
        endif;

        // [ 3 ] If both passed it is safe to drop the record cleanly
        return $category->delete();

    }

}
