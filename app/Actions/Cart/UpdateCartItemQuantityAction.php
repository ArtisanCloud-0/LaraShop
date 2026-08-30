<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class UpdateCartItemQuantityAction
{
    public function execute(int $variantId, int $newQty): void
    {
        if ($newQty < 1) {
            throw new InvalidArgumentException(
                'Quantity must be at least 1.'
            );
        } // Validate quantity

        $variant = ProductDetails::query()
            ->findOrFail($variantId); // Ensure the variant exists

        if ($variant->stock < 1) {
            throw new InvalidArgumentException(
                'This product is out of stock.'
            );
        } // Check if the variant is in stock

        if ($newQty > $variant->stock) {
            throw new InvalidArgumentException(
                "Only {$variant->stock} item(s) available."
            );
        } // Validate that the new quantity does not exceed available stock

        if (Auth::check()) { // Authenticated user cart
            $cart = Cart::query()
                ->where('user_id', Auth::id())
                ->first(); // Retrieve the authenticated user's cart

            if (!$cart) { // If the cart does not exist, throw an exception
                throw new InvalidArgumentException(
                    'Shopping cart not found.'
                );
            }

            $cartItem = CartItem::query()
                ->where('cart_id', $cart->id)
                ->where('product_details_id', $variantId)
                ->first(); // Retrieve the specific cart item for the given variant

            if (!$cartItem) { // If the cart item does not exist, throw an exception
                throw new InvalidArgumentException(
                    'Cart item not found.'
                );
            }

            $cartItem->update([
                'quantity' => $newQty,
            ]); // Update the quantity of the existing cart item

            return; // Exit the function after handling the authenticated user's cart
        }

        // Guest cart
        $cart = Session::get('cart', []);

        if (!isset($cart[$variantId])) { // If the cart item does not exist in the guest cart, throw an exception
            throw new InvalidArgumentException(
                'Cart item not found.'
            );
        }

        $cart[$variantId]['quantity'] = $newQty; // Update the quantity of the existing cart item in the guest cart

        Session::put('cart', $cart); // Save the updated guest cart in the session
    }
}
