<?php

namespace App\Services\Checkout;

use App\Enums\OrderStatus;
use App\Models\OrderLedger;
use App\Models\OrderItem;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{

    public function processCheckout(array $cartItems, ?int $userId = null, ?array $guestInfo = null): OrderLedger
    {
        return DB::transaction(function () use ($cartItems, $userId, $guestInfo) {
            $totalAmount = 0;

            // Create Order Parent Record
            $order = OrderLedger::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'      => $userId,
                'guest_name'   => $guestInfo['name'] ?? null,  // Add guest name
                'guest_email'  => $guestInfo['email'] ?? null, // Add guest email
                'status'       => OrderStatus::PAID,
                'total_amount' => 0,
            ]);

            foreach ($cartItems as $item) {
                // Standardize key extraction for both arrays and Eloquent models
                $productDetailsId = is_array($item)
                    ? ($item['product_details_id'] ?? $item['id'] ?? null)
                    : ($item->product_details_id ?? $item->id ?? null);

                $quantity = is_array($item)
                    ? ($item['quantity'] ?? 1)
                    : ($item->quantity ?? 1);

                if (!$productDetailsId) {
                    continue;
                }

                $detail = ProductDetails::findOrFail($productDetailsId);

                dd($detail);

                $detail->decrement('stock', $quantity);

                $subtotal = $detail->price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_ledger_id'    => $order->id,
                    'product_details_id' => $detail->id,
                    'quantity'           => $quantity,
                    'price'              => $detail->price,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });
    }
}
