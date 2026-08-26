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
                // Extract ID safely regardless of key variation or model structure
                $variantId = is_array($item)
                    ? ($item['product_details_id'] ?? $item['product_detail_id'] ?? $item['id'] ?? null)
                    : ($item->product_details_id ?? $item->product_detail_id ?? $item->id ?? null);

                if (!$variantId) {
                    continue;
                }

                $detail = ProductDetails::findOrFail($variantId);
                $detail->decrement('stock', $item['quantity']);

                $subtotal = $detail->price * $item['quantity'];
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_ledger_id'    => $order->id,
                    'product_details_id' => $detail->id,
                    'quantity'           => $item['quantity'],
                    'price'              => $detail->price,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });
    }
}
