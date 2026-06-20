<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class UpsertCategoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute a create or update statement on a category item.
     *
     * @param array $data
     */
    public function execute(array $data, ?Category $category = null): Category
    {

        // [ 1 ] Check if the model instance is provided, (No => Create Category, Yes => Update Category)
        $category ??= new Category();

        // [ 2 ] Fill the model with provided data
        $category->fill([
            'name'       => $data['name'],
            'slug'       => Str::slug($data['name']),
            'parent_id'  => $data['parent_id'] ?? null,
            'is_visible' => $data['is_visible'] ?? true,
        ]);

        // [ 3 ] Save Data
        $category->save();

        // [ 4 ] Return Result
        return $category;

    }

}
