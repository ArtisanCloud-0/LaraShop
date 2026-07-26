<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddToCartAction
{
    /**
     * Add product variant (ProductDetails) to DB Cart or Session Cart.
     */
    public function execute(ProductDetails $variant, int $quantity = 1): void
    {
        if (Auth::check()) {
            // --- AUTHENTICATED USER (DATABASE) ---
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            $existingItem = $cart->items()
                ->where('product_details_id', $variant->id)
                ->first();

            if ($existingItem) {
                $existingItem->increment('quantity', $quantity);
            } else {
                $cart->items()->create([
                    'product_details_id' => $variant->id,
                    'quantity'           => $quantity,
                ]);
            }
        } else {
            // --- GUEST USER (SESSION) ---
            $cart = Session::get('cart', []);

            if (isset($cart[$variant->id])) {
                $cart[$variant->id]['quantity'] += $quantity;
            } else {
                // Eager-load parent product if not already loaded for display info
                $product = $variant->relationLoaded('product') 
                    ? $variant->product 
                    : $variant->product()->first();

                $cart[$variant->id] = [
                    'product_details_id' => $variant->id,
                    'product_id'         => $variant->product_id,
                    'name'               => $product?->name ?? 'Product',
                    'code'               => $variant->code,
                    'options'            => $variant->options, // Array: ['color' => 'Red', 'size' => 'XL']
                    'price'              => $variant->price,   // Stored in cents
                    'quantity'           => $quantity,
                    'image'              => $product?->primary_image ?? null,
                ];
            }

            Session::put('cart', $cart);
        }
    }
}