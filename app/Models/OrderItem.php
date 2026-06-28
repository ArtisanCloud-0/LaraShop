<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['order_ledger_id', 'product_details_id', 'price', 'quantity'])]
class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'quantity' => 'integer',
        ];
    }

    /**
     * Custom Attribute: Calculate subtotal for this item line.
     */
    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->price * $this->quantity,
        );
    }

    protected function formattedSubtotal(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->subtotal / 100, 2),
        );
    }

    public function orderLedger(): BelongsTo
    {
        return $this->belongsTo(OrderLedger::class);
    }

    /**
     * Connect to SKU, but include withTrashed() if you use soft deletes
     * so older orders don't break when a variant is discontinued.
     */
    public function productDetails(): BelongsTo
    {
        return $this->belongsTo(ProductDetails::class)->withTrashed();
    }

}
