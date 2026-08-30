<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Attributes\Fillable;

use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Enums\OrderStatus;
use LogicException;

class OrderLedger extends Model
{
    /** @use HasFactory<\Database\Factories\OrderLedgerFactory> */
    use HasFactory;

    protected $table = 'order_ledgers'; // Explicitly define the table name for clarity

    protected $fillable = [ // Mass assignable attributes
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_amount',
        'status',
        'payment_gateway',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
            // Cast to a PHP Native Enum for strict status safety (pending, paid, shipped)
            'status' => OrderStatus::class,
        ]; // Cast the status to the OrderStatus enum for type safety
    }

    /**
     * Custom Attribute: Formats integer cents into a displayable currency string.
     * e.g., 10000 becomes "$100.00"
     */
    protected function formattedTotal(): Attribute // Custom attribute to format the total amount in cents to a dollar string
    {
        return Attribute::make(
            get: fn() => '$' . number_format($this->total_amount / 100, 2),
        );
    }

    /**
     * Boot Method Safeguard: Prevents updating an order once it is completed or cancelled.
     */
    protected static function booted(): void
    {
        parent::boot(); // Call the parent boot method to ensure any inherited boot logic is executed

        static::creating(function (OrderLedger $order) {
            $order->public_token ??= bin2hex(random_bytes(32)); // Generate a unique public token if not already set
        });

        static::updating(function (OrderLedger $order): void { // Hook into the updating event to enforce business rules
            $originalStatus = $order->getOriginal('status'); // Get the original status before the update
            $immutableStatuses = [OrderStatus::COMPLETED, OrderStatus::CANCELLED,]; // Define statuses that should not be modified
            if (in_array($originalStatus, $immutableStatuses, true)) { // Check if the original status is in the immutable statuses
                // Throw an exception to prevent modification of completed or cancelled orders
                throw new LogicException('Completed or cancelled orders cannot be modified.');
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
