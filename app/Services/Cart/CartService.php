<?php

namespace App\Services\Cart;

use App\Models\Cart;

use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Fetch items regardless of storage driver.
     */
    public function getItems(): array
    {
        if (Auth::check()) {
            $cart = Cart::with('items.productDetail.product')
                ->where('user_id', Auth::id())
                ->first();

            if (!$cart) return [];

            return $cart->items->map(function ($item) {
                return [
                    'product_detail_id' => $item->product_detail_id,
                    'name'              => $item->productDetail->product->name ?? 'Product',
                    'price'             => $item->productDetail->price,
                    'quantity'          => $item->quantity,
                ];
            })->toArray();
        }

        return session()->get('cart', []);
    }

    /**
     * Clear items after order placement.
     */
    public function clearCart(): void
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
    }
}
