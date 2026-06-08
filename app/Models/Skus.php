<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['product_id', 'code', 'price', 'stock', 'options'])]
class Skus extends Model
{
    /** @use HasFactory<\Database\Factories\SkusFactory> */
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
