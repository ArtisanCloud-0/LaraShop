<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['cart_id', 'product_details_id', 'quantity'])]
class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function productDetails(): BelongsTo
    {
        return $this->belongsTo(ProductDetails::class);
    }

}
