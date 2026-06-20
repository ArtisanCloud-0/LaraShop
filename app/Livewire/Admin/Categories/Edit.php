<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\Category;
use App\Actions\Category\UpsertCategoryAction;

class Edit extends Component
{

    /* 
    * ================================
    * ===== Variables Declartion =====
    * ================================
    */
    public Category $category;

    public string $name = '';
 
    public ?int $parent_id = null;
 
    public bool $is_visible = true;

    /* 
    * ================================
    * ===== Mount category data ======
    * ================================
    */
    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
        $this->is_visible = $category->is_visible;
    }

    /* 
    * =============================
    * ===== Validation Rules ======
    * =============================
    */
    protected function rules(): array
    {
        return [
            // Ignore the current category ID during the unique check so it doesn't fail when saving
            'name'       => 'required|string|min:3|max:100|unique:categories,name,' . $this->category->id,
            'parent_id'  => 'nullable|integer|exists:categories,id',
            'is_visible' => 'boolean',
        ];
    }

    /* 
    * ================================
    * ====== Edit category data ======
    * ================================
    */
    public function save(UpsertCategoryAction $action)
    {
        // [ 1 ] Validate Data
        $validatedData = $this->validate();

        // [ 2 ] Edit Process
        try {
            // [ 2-1 ] Pass the validated data AND the existing category instance to trigger "Update Mode"
            $action->execute($validatedData, $this->category);

            // [ 2-2 ] Flash success message
            session()->flash('status', 'Category '. $validatedData['name'] .' data updated successfully!');

            // [ 2-3 ] Return to the categories table page
            return redirect()->route('panel.categories');

        } catch (\Exception $e) {

            // [ 2-1 ] Show error messages if not able to update record
            session()->flash('error', 'Category '. $validatedData['name'] .' data failed to update!');

        }
    }

    /* 
    * ================================
    * ====== Rendering the view ======
    * ================================
    */
    public function render()
    {

        // Exclude the current category from the parent dropdown so it can't become a child of itself
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $this->category->id)
            ->get();

        return view(
            'livewire.admin.categories.edit',
            [
                'parentCategories' => $parentCategories
            ]
        );
    }
}
