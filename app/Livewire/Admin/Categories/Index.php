<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

use App\Models\Category;
use App\Actions\Category\DeleteCategoryAction;

class Index extends Component
{
    use WithPagination;

    /**
     * Delete a category using our safe decoupled action class engine.
     */
    public function deleteCategory(int $id, DeleteCategoryAction $deleteAction)
    {
        // [ 1 ] Find the category
        $category = Category::findOrFail($id);

        // [ 2 ] Delete Process
        try {
            // [ 2-1 ] Hand the model instance to the safety-gated action class
            $deleteAction->execute($category);
            
            // [ 2-2 ] Flash success message
            session()->flash('status', 'Category cleared successfully from record mappings.');

        } catch (\Exception $e) {
            
            // Flash any thrown safety guardrail errors (e.g., contains products or children)
            session()->flash('error', $e->getMessage());
        
        }
    
    }

    #[Title('Manage Categories')]
    public function render()
    {
        return view(
            'livewire.admin.categories.index',
            ['categories' => Category::with(['parent'])->withCount(['products'])->paginate(10)]
        );
    }
}
