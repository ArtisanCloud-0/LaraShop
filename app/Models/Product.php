<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory; // Enables factory methods for testing and seeding

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'is_visible',
        'cover_image',
    ]; // Mass assignment protection for the model's attributes

    protected function casts(): array
    { // Casts the 'is_visible' attribute to a boolean when accessed or set
        return [
            'is_visible' => 'boolean',
            'cover_image' => 'string',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class); // Defines a relationship indicating that each product belongs to a single category
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetails::class, 'product_id'); // Defines a relationship indicating that each product can have multiple product details (variants)
    }

    public function getPrimaryImageAttribute(): ?string
    {
        if ($this->cover_image) { // If a cover image is set for the product, return it as the primary image
            return $this->cover_image;
        }

        $firstVariant = $this->productDetails->first(fn($detail) => !empty($detail->images)); // Find the first product detail that has images

        return $firstVariant?->images[0] ?? null; // Return the first image of the first variant with images, or null if none exist
    }

    public function getMinPriceAttribute(): int|float
    {
        return $this->productDetails->min('price') ?? 0; // Returns the minimum price among the product's details, or 0 if there are no details
    }

    public function getMaxPriceAttribute(): int|float
    {
        return $this->productDetails->max('price') ?? 0; // Returns the maximum price among the product's details, or 0 if there are no details
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->productDetails->isEmpty()) { // If there are no product details, return a default price format
            return '$0.00';
        }

        $min = $this->min_price; // Get the minimum price from the product details
        $max = $this->max_price; // Get the maximum price from the product details

        if ($min === $max) { // If the minimum and maximum prices are the same, return a single formatted price
            return '$' . number_format($min / 100, 2);
        }

        return 'From $' . number_format($min / 100, 2); // If the prices vary, return a formatted string indicating the starting price
    }
}
