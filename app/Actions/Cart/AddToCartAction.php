<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class AddToCartAction
{
    public function execute(int $variantId, int $quantity = 1): void
    {
        if ($quantity < 1) { // Validate quantity
            throw new InvalidArgumentException(
                'Quantity must be at least 1.'
            );
        }

        $variant = ProductDetails::query()
            ->findOrFail($variantId); // Ensure the variant exists

        if ($variant->stock < 1) { // Check if the variant is in stock
            throw new InvalidArgumentException(
                'This product is out of stock.'
            );
        }

        if (Auth::check()) { // Authenticated user cart
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]); // Create a new cart for the user if it doesn't exist

            $cartItem = CartItem::query()
                ->where('cart_id', $cart->id)
                ->where('product_details_id', $variantId)
                ->first(); // Check if the item is already in the cart

            $currentQuantity = $cartItem?->quantity ?? 0; // Get the current quantity of the item in the cart
            $newQuantity = $currentQuantity + $quantity; // Calculate the new quantity after adding the requested amount

            if ($newQuantity > $variant->stock) {
                throw new InvalidArgumentException(
                    "Only {$variant->stock} item(s) available."
                );
            } // Update the quantity if the item is already in the cart, otherwise create a new cart item

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $newQuantity,
                ]); // Update the quantity of the existing cart item
            } else {
                $cart->items()->create([
                    'name' => $variant->product->name,
                    'product_details_id' => $variantId,
                    'quantity' => $quantity,
                    'price' => $variant->price,
                    'options' => $variant->options,
                ]); // Create a new cart item with the specified quantity
            }

            return; // Exit the function after handling the authenticated user's cart
        }

        // Guest cart
        $cart = Session::get('cart', []);

        $currentQuantity = (int) ($cart[$variantId]['quantity'] ?? 0); // Get the current quantity of the item in the guest cart
        $newQuantity = $currentQuantity + $quantity; // Calculate the new quantity after adding the requested amount

        if ($newQuantity > $variant->stock) {
            throw new InvalidArgumentException(
                "Only {$variant->stock} item(s) available."
            );
        } // Update the quantity if the item is already in the guest cart, otherwise create a new cart item

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] = $newQuantity; // Update the quantity of the existing cart item in the guest cart
        } else {
            $cart[$variantId] = [
                'name' => $variant->product->name,
                'product_details_id' => $variantId,
                'quantity' => $quantity,
                'price' => $variant->price,
                'options' => $variant->options,
            ]; // Create a new cart item in the guest cart with the specified quantity
        }

        Session::put('cart', $cart); // Save the updated guest cart in the session
    }
}
