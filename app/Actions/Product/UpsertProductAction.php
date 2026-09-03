<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Str;

class UpsertProductAction
{
    public function execute(array $data, ?Product $product = null): Product
    { // This method either updates an existing product or creates a new one based on the provided data. If a Product instance is passed, it updates that product; otherwise, it creates a new one.
        $product = $product ?? new Product(); // If no product is provided, create a new Product instance

        $product->name = $data['name']; // Set the product's name from the provided data
        $product->category_id = $data['category_id']; // Set the product's category ID from the provided data
        $product->description = $data['description'] ?? null; // Set the product's description from the provided data, or null if not provided
        $product->is_visible = (bool) ($data['is_visible'] ?? true); // Set the product's visibility status from the provided data, defaulting to true if not provided
        $product->cover_image = $data['cover_image'] ?? $product->cover_image; // Set the product's cover image from the provided data, or retain the existing cover image if not provided  

        if (!$product->exists) { // If the product is new (does not exist in the database), generate a unique slug based on the product's name
            $product->slug = $this->generateUniqueSlug($data['name']);
        }

        $product->save(); // Save the product to the database, either creating a new record or updating an existing one

        return $product->fresh(); // Return the fresh instance of the product from the database, ensuring that any changes made during the save operation are reflected in the returned object
    }

    private function generateUniqueSlug(string $name): string // This method generates a unique slug for the product based on its name. It appends a random number to the slug if a product with the same slug already exists in the database.
    {
        do { // Keep generating a new slug until a unique one is found
            $slug = Str::slug($name) . '-' . random_int(1000, 9999); // Generate a slug from the product name and append a random number between 1000 and 9999 to ensure uniqueness
        } while (Product::query()->where('slug', $slug)->exists()); // Check if a product with the generated slug already exists in the database; if it does, repeat the process to generate a new slug

        return $slug; // Return the unique slug that was generated
    }
}
