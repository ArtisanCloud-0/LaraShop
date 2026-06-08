<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Attributes\Fillable;

use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Enums\OrderStatus;

#[Fillable(['order_number', 'user_id', 'total_amount', 'status', 'payment_gateway'])]
class OrderLedger extends Model
{
    /** @use HasFactory<\Database\Factories\OrderLedgerFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
            // Cast to a PHP Native Enum for strict status safety (pending, paid, shipped)
            'status' => OrderStatus::class,
        ];
    }

    /**
     * Custom Attribute: Formats integer cents into a displayable currency string.
     * e.g., 10000 becomes "$100.00"
     */
    protected function formattedTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => '$' . number_format($this->total_amount / 100, 2),
        );
    }

    /**
     * Boot Method Safeguard: Prevents updating an order once it is completed or cancelled.
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($order) {
            if ($order->getOriginal('status') === OrderStatus::COMPLETED) {
                throw new \Exception("Cannot modify a completed financial ledger record.");
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
