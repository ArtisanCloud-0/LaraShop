<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetails extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDetailsFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'product_details';

    protected $fillable = [
        'code',
        'price',
        'stock',
        'options',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'price'   => 'integer',
            'stock'   => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}