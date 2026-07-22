<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddToCartAction
{
    /**
     * Add product to DB Cart or Session Cart.
     */
    public function execute(Product $product, int $quantity = 1): void
    {
        if (Auth::check()) {
            // --- AUTHENTICATED USER (DATABASE) ---
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            $existingItem = $cart->items()->where('product_id', $product->id)->first();

            if ($existingItem) {
                $existingItem->increment('qty', $quantity);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'price'      => $product->price,
                    'qty'        => $quantity,
                ]);
            }
        } else {
            // --- GUEST USER (SESSION) ---
            $cart = Session::get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['qty'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id'      => $product->id,
                    'name'    => $product->name,
                    'variant' => $product->variant ?? 'Standard',
                    'price'   => $product->price,
                    'qty'     => $quantity,
                    'image'   => $product->primary_image ?? null,
                ];
            }

            Session::put('cart', $cart);
        }
    }
}