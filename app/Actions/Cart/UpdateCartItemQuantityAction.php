<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UpdateCartItemQuantityAction
{
    /**
     * Update item quantity by product_details_id for Auth User (DB) or Guest (Session).
     */
    public function execute(int $productDetailsId, int $newQty): array
    {
        if (Auth::check()) {
            $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            if ($newQty > 0) {
                // Update quantity for the given variant ID
                CartItem::where('cart_id', $userCart->id)
                    ->where('product_details_id', $productDetailsId)
                    ->update(['quantity' => $newQty]);
            } else {
                // Delete item if quantity drops to zero or less
                CartItem::where('cart_id', $userCart->id)
                    ->where('product_details_id', $productDetailsId)
                    ->delete();
            }

            return $userCart->items()
                ->get()
                ->keyBy('product_details_id')
                ->toArray();
        } else {
            $cart = Session::get('cart', []);

            if (isset($cart[$productDetailsId])) {
                if ($newQty > 0) {
                    $cart[$productDetailsId]['quantity'] = $newQty;
                } else {
                    unset($cart[$productDetailsId]);
                }

                Session::put('cart', $cart);
            }

            return $cart;
        }
    }
}