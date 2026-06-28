<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'images', 'category_id', 'description', 'is_visible'])]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * Define modern Laravel 13 attribute casting behavior.
     */
    protected function casts(): array
    {
        return [
            'images' => 'array', // Forces JSON to act as a sequential array automatically
            'is_visible' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetails::class, 'product_id');
    }

}
