<?php

namespace App\Services\Checkout;

use App\Enums\OrderStatus;
use App\Models\OrderLedger;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class CheckoutService
{
    /**
     * Create an order and reserve inventory atomically.
     *
     * The transaction guarantees that:
     *
     * - inventory is locked while being checked
     * - insufficient stock prevents checkout
     * - order creation and inventory changes succeed/fail together
     * - concurrent checkout requests cannot oversell the locked variant
     * - historical order prices come from the database at checkout time
     */
    public function process(
        ?int $userId,
        array $items,
        array $customerData = [],
    ): OrderLedger { // Process the checkout and create an order ledger entry
        if (!empty($customerData)) { // Check if customer data is provided
            $this->validateCustomerData($customerData); // Validate the customer data before proceeding with the checkout
        } else {
            $customerData = [
                'name' => Auth()->user()?->name,
                'email' => Auth()->user()?->email,
                'phone' => Auth()->user()?->phone ?? null,
            ]; // Set default customer data for guest checkout if no customer data is provided
        }

        if ($items === []) { // Ensure that the cart is not empty before proceeding with checkout
            throw new RuntimeException(
                'Cannot checkout an empty cart.'
            );
        }

        return DB::transaction(function () use (
            $userId,
            $items,
            $customerData,
        ): OrderLedger { // Start a database transaction to ensure atomicity
            $orderItems = []; // Initialize an array to hold order item snapshots
            $totalAmount = 0; // Initialize total amount in cents

            foreach ($items as $item) { // Iterate through each item in the cart
                $variantId = (int) ($item['product_details_id'] ?? 0); // Get the product variant ID, defaulting to 0 if not provided
                $quantity = (int) ($item['quantity'] ?? 0); // Get the quantity of the product, defaulting to 0 if not provided

                if ($variantId < 1) { // Validate that the product variant ID is valid
                    throw new InvalidArgumentException(
                        'Invalid product variant.'
                    );
                }

                if ($quantity < 1) { // Validate that the quantity is at least 1 
                    throw new InvalidArgumentException(
                        'Product quantity must be at least 1.'
                    );
                }

                /*
                 * Lock the inventory row for the duration of the
                 * transaction.
                 *
                 * If another checkout attempts to modify the same
                 * variant concurrently, it must wait for this
                 * transaction to finish.
                 */
                $detail = ProductDetails::query()
                    ->with('product')
                    ->lockForUpdate()
                    ->findOrFail($variantId);

                if ($detail->stock < $quantity) { // Check if there is sufficient stock for the requested quantity
                    throw new RuntimeException(
                        "Insufficient stock for {$detail->product->name}."
                    );
                }

                /*
                 * Always use the current database price.
                 *
                 * Never trust a price stored in the browser or
                 * session as the authoritative financial value.
                 */
                $unitPrice = (int) $detail->price; // Get the current price of the product variant in cents
                $subtotal = $unitPrice * $quantity; // Calculate the subtotal for this item in cents

                $totalAmount += $subtotal; // Accumulate the total amount for the order in cents

                /*
                 * Store an order snapshot.
                 *
                 * Future product changes must not alter historical
                 * order information.
                 */
                $orderItems[] = [
                    'product_details_id' => $detail->id,
                    'product_name' => $detail->product->name,
                    'sku' => $detail->sku,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                /*
                 * The row is locked, so this decrement is protected
                 * against concurrent checkout attempts.
                 */
                $detail->decrement('stock', $quantity);
            }

            /*
             * No payment gateway has confirmed payment yet.
             *
             * Therefore the order starts as PENDING.
             */
            $order = OrderLedger::create([
                'order_number' => $this->generateOrderNumber(),

                'user_id' => $userId,

                /*
                 * Snapshot customer information at checkout time.
                 */
                'customer_name' => $customerData['name'],
                'customer_email' => $customerData['email'],
                'customer_phone' => $customerData['phone'] ?? null,

                'total_amount' => $totalAmount,
                'status' => OrderStatus::PENDING,
                'payment_gateway' => null,
            ]);

            foreach ($orderItems as $item) { // Create order item records associated with the order
                $order->items()->create($item);
            }

            return $order->fresh(['items']); // Return the newly created order with its associated items
        });
    }

    /**
     * Validate customer information before starting the transaction.
     */
    private function validateCustomerData(array $customerData): void
    {
        if (blank($customerData['name'] ?? null)) { // Check if the customer name is provided and not blank
            throw new InvalidArgumentException(
                'Customer name is required.'
            );
        }

        $email = $customerData['email'] ?? null;

        if (
            blank($email) ||
            ! filter_var($email, FILTER_VALIDATE_EMAIL)
        ) { // Validate that the customer email is provided and is in a valid format
            throw new InvalidArgumentException(
                'A valid customer email is required.'
            );
        }
    }

    /**
     * Generate a human-readable unique order number.
     *
     * Example:
     * LS-20260829-A1B2C3
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'LS-'
                . now()->format('Ymd')
                . '-'
                . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (
            OrderLedger::query()
            ->where('order_number', $orderNumber)
            ->exists() // Check if the generated order number already exists in the database to ensure uniqueness
        );

        return $orderNumber;
    }

    public function getOrderByNumber(string $orderNumber): ?OrderLedger
    {
        return OrderLedger::query()
            ->with(['items.productDetails.product'])
            ->where('order_number', $orderNumber)
            ->first();
    }
}
