<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItems;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UpdateCartItemQuantityAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Update item quantity for either Auth User (DB) or Guest (Session).
     */
    public function execute(int $itemId, int $newQty): array
    {

        if(Auth::check()) { // If the user is login
            
            // [ 1 ] Grap the cart that is belongs to the loged user
            $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            // [ 2 ] Update the cart
            if($newQty > 0) {
                
                // [ 2-1 ] Update the cart item
                CartItem::where('cart_id', $userCart->id)
                    ->where('id', $product_details_id)
                    ->update(['quantity' => $newQty]);

            } else {

                // [ 2-1 ] Delete the cart item
                CartItem::where('cart_id', $userCart->id)
                    ->where('id', $product_details_id)
                    ->delete();

            }

            // [ 3 ] Return fresh cart items formatted as array
            return $userCart->items()
                ->get()
                ->keyBy('id')
                ->toArray();

        } else {

            // [ 1 ] Get the session
            $cart = Session::get('cart', []);

            // [ 2 ] Check if the session have the cart item before
            if(isset($cart[$itemId])) {

                // [ 2-1 ] If yes, then update the Quantity
                if($newQty > 0) { 
                    // Add new Quantity
                    $cart[$itemId]['qty'] = $newQty;
                } else {
                    // Remove item
                    unset($cart($itemId));
                }

                // [ 3 ] Update the session
                Session::put('cart', $cart);

            }

            // [ 4 ] Return new cart
            return $cart;

        }

    }

}
