<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetails extends Model
{
    use HasFactory, SoftDeletes; // Enables factory methods for testing and seeding, and soft deletes for the model

    protected $table = 'product_details'; // Specifies the database table associated with this model

    protected $fillable = [ // Mass assignment protection for the model's attributes
        'code',
        'price',
        'stock',
        'options',
        'images',
        'product_id',
    ];

    protected function casts(): array
    { // Casts the 'options' and 'images' attributes to arrays, and 'stock' to an integer when accessed or set
        return [
            'options' => 'array',
            'images'  => 'array',
            'stock'   => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id'); // Defines a relationship indicating that each product detail belongs to a single product
    }

    /**
     * Store price in cents.
     *
     * The database always stores an integer number of cents.
     * Formatting should only happen at the presentation layer.
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(int $value): int => $value,

            set: fn(int|float|string $value): int =>
            (int) round(((float) $value) * 100),
        );
    }
}
