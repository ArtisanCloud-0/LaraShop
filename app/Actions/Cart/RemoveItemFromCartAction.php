<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RemoveItemFromCartAction
{
    /**
     * Remove item by product_details_id from DB or Session cart.
     */
    public function execute(int $productDetailsId): void
    {
        if (Auth::check()) {
            $userCart = Cart::where('user_id', Auth::id())->first();

            if ($userCart) {
                CartItem::where('cart_id', $userCart->id)
                    ->where('product_details_id', $productDetailsId)
                    ->delete();
            }
        } else {
            $cart = Session::get('cart', []);

            if (isset($cart[$productDetailsId])) {
                unset($cart[$productDetailsId]);
                Session::put('cart', $cart);
            }
        }
    }
}