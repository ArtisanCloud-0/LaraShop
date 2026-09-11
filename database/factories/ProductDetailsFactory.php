<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductDetails>
 */
class ProductDetailsFactory extends Factory
{
    protected $model = ProductDetails::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'code' => fake()->unique()->bothify('SKU-####??'),
            'price' => 49.99,
            'stock' => 10,
            'options' => null,
            'images' => null,
        ];
    }
}
