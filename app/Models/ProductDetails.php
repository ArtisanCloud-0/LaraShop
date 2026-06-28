<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'price', 'stock', 'options', 'product_id'])]
class ProductDetails extends Model
{
    /** @use HasFactory<\Database\Factories\ProductDetailsFactory> */
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'options' => 'array', // Dynamically decodes variation specs like {"size": "XL"}
            'price' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
