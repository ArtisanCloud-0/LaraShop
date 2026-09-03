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
     * Store price in cents, return float for display.
     */
    protected function price(): Attribute
    {
        return Attribute::make( // Defines a custom accessor and mutator for the 'price' attribute to handle storage in cents and display as a float
            get: fn(int $value) => number_format($value / 100, 2, '.', ''), // Converts the stored integer value (in cents) to a formatted float string for display
            set: fn(float|string $value) => (int) round(((float) $value) * 100), // Converts the input float or string value to an integer (in cents) for storage in the database
        );
    }
}
