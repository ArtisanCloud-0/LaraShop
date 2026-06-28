<?php

namespace App\Actions\Product;

use App\Models\Product;

use Illuminate\Support\Str; 

class UpsertProductAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Execute the product creation or update mapping logic.
     */
    public function execute(array $data, ?Product $product = null): Product
    {
        $product = $product ?? new Product();

        $product->name         = $data['name'];
        $product->category_id  = $data['category_id'];
        $product->descripiton  = $data['descripiton'] ?? null; // Matching schema typo
        $product->is_visible   = $data['is_visible'] ?? true;
        
        // Cast or default the JSON array structural payload safely
        $product->images       = $data['images'] ?? [];

        if (!$product->exists) {
            $product->slug = Str::slug($data['name']) . '-' . rand(1000, 9999);
        }

        $product->save();

        return $product;
    }
}
