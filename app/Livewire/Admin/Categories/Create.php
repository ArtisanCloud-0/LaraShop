<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\Category;
use App\Actions\Category\UpsertCategoryAction;

class Create extends Component
{
    /*
    * ====================================
    * ====== Validate incoming data ======
    * ====================================
    **/ 
    #[Validate('string')]
    #[Validate('required', message: 'Category name is required, please fill it')]
    #[Validate('unique:' . Category::class, message: 'Category name is unique can not be repeated', onUpdate: false)]
    #[Validate('min:3', message: 'Category name most be at least 3 characters')]
    public string $name = '';

    #[Validate('nullable|integer')]
    public ?int $parent_id = null;

    #[Validate('boolean')]
    public bool $is_visible = true;

    /*
    * ======================================
    * ====== Saving the category data ======
    * ======================================
    **/ 
    public function save(UpsertCategoryAction $action)
    {
        // [ 1 ] Validate the incoming data
        $validatedDate = $this->validate();

        // [ 2 ] Try to create new Category data
        try {
            
            // [ 2-1 ] Hand off the validated data to the upsert action
            $action->execute($validatedDate);

            // [ 2-2 ] Flash success message
            session()->flash('status', 'Category '. $validatedDate['name'] .' data inserted successfully.');

            // [ 2-3 ] Return to categories table view
            return redirect()->route('panel.categories');

        } catch (Exception $e) {
            
            // [ 2-1 ] Catch domain exceptions (e.g., business logic errors thrown by actions)
            $this->addError('form_execution', $e->getMessage());
        
        }
    }

    /*
    * =============================
    * ====== Render the view ======
    * =============================
    **/ 
    public function render()
    {
        return view(
            'livewire.admin.categories.create', 
            [
                'parentCategories' => Category::whereNull('parent_id')->get()
            ]
        );
    }
}
