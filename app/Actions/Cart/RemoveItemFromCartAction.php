<?php

namespace App\Actions\Cart;

use App\Models\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RemoveItemFromCartAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(int $itemId)
    {
        
        if (Auth::check()) {
            $userCart = Cart::where('user_id', Auth::id())->first();
            
            if ($userCart) {
                $userCart->items()->where('id', $itemId)->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }

    }

}
