<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class MergeGuestCartWithUserCartService
{
    public function mergeItems(int $userID): void
    {
        $sessionCart = session()->get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        DB::transaction(function () use ($userID, $sessionCart) {
            // Find existing cart or generate a new ULID cart automatically
            $userCart = Cart::firstOrCreate(
                ['user_id' => $userID]
            );

            foreach ($sessionCart as $item) {
                $cartItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_details_id', $item['product_details_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity', $item['quantity']);
                } else {
                    CartItem::create([
                        'cart_id'            => $userCart->id,
                        'product_details_id' => $item['product_details_id'],
                        'quantity'           => $item['quantity'],
                    ]);
                }
            }

            // Clear session cart after successful merge
            session()->forget('cart');
        });
    }
}
