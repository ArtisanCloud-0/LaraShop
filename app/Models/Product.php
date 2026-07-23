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

    /**
     * Get the main image path.
     */
    public function getPrimaryImageAttribute(): ?string
    {
        // Returns the first image from the JSON array, or null if empty
        return !empty($this->images) && is_array($this->images) ? $this->images[0] : null;
    }

    /**
     * Get the minimum price formatted or raw (in cents).
     */
    public function getMinPriceAttribute(): float | int
    {
        $minCents = $this->productDetails->min('price') ?? 0;
        return $minCents;
    }

    /**
     * Get the minimum price formatted or raw (in cents).
     */
    public function getMaxPriceAttribute(): float | int
    {
        $maxCents = $this->productDetails->max('price') ?? 0;
        return $maxCents;
    }

    /**
     * Get a clean formatted price string for display.
     */
    public function getFormattedPriceAttribute(): string
    {
        // [ 1 ] Check if the product does not have variants
        if($this->productDetails->isEmpty()) {
            return '$0.00';
        }

        // [ 2 ] Store min & max prices values for easy refreneces
        $min = $this->min_price;
        $max = $this->max_price;

        // [ 3 ] If variants have the same price, then show standard single price
        if($min === $max) {
            return '$' . number_format($min, 2);
        }

        // [ 4 ] If deferents then return prices from minimum price
        return 'From $' . number_format($min, 2);

    }

}
