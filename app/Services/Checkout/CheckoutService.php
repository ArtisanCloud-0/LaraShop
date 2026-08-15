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
	
	public function processCheckout(array $cartItems, ?int $userId = null): OrderLedger
    {
        // Using database transactions with closure inherit
        return DB::transaction(function () use ($cartItems, $userId) {
            
            $totalAmount = 0;

            // [ 1 ] Create Order Parent Record (user_id can safely be null)
            $order = OrderLedger::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'      => $userId,
                'status'       => OrderStatus::PAID,
                'total_amount' => 0,
            ]);

            // [ 2 ] Attach items & deduct variant stock in product_details
            foreach ($cartItems as $item) {
                $detail = ProductDetails::findOrFail($item['product_details_id']);

                // Deduct stock safely
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

            // [ 3 ] Update total amount
            $order->update(['total_amount' => $totalAmount]);

            // [ 4 ] Return Order
            return $order;

        });
    }

}