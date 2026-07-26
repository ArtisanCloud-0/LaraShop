<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\On; 
use Livewire\Attributes\Layout; 

use App\Models\Cart as CartModel;
use App\Models\CartItem as CartItemModel;
use App\Actions\Cart\RemoveItemFromCartAction;
use App\Actions\Cart\UpdateCartItemQuantityAction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.store')]
class Cart extends Component
{
    public array $cartItems = [];

    public function mount(): void
    {
        $this->loadCartItems();
    }

    public function loadCartItems(): void
    {
        if (Auth::check()) {
            // Eager-load variant and its parent product
            $userCart = CartModel::with(['items.variant.product'])
                ->where('user_id', Auth::id())
                ->first();

            if ($userCart) {
                // Map database models into a standard array format matching session carts
                $this->cartItems = $userCart->items->mapWithKeys(function (CartItemModel $item) {
                    $variant = $item->variant;
                    $product = $variant?->product;

                    return [
                        $item->product_details_id => [
                            'product_details_id' => $item->product_details_id,
                            'name'               => $product?->name ?? 'Product',
                            'options'            => $variant?->options ?? [],
                            'price'              => $variant?->price ?? 0, // Cents
                            'quantity'           => $item->quantity,
                            'image'              => $product?->primary_image ?? null,
                        ]
                    ];
                })->toArray();
            } else {
                $this->cartItems = [];
            }
        } else {
            $this->cartItems = Session::get('cart', []);
        }
    }

    public function updateQuantity(int $variantId, int $newQty): void
    {
        resolve(UpdateCartItemQuantityAction::class)->execute($variantId, $newQty);
        $this->loadCartItems();
        
        // Notify the navbar counter to re-render
        $this->dispatch('cart-updated');

    }

    public function removeItem(int $variantId): void
    {
        resolve(RemoveItemFromCartAction::class)->execute($variantId);
        $this->loadCartItems();
        
        // Notify the navbar counter to re-render
        $this->dispatch('cart-updated');
        
    }

    #[On('cart-updated')]
    public function handleCartUpdated(): void
    {
        $this->loadCartItems();
    }

    public function render()
    {
        // Calculate subtotal from cents and convert to dollars
        $subtotalInCents = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cartItems));
        $subtotal = $subtotalInCents;

        return view('livewire.store.cart', [
            'subtotal' => $subtotal
        ]);
    }
}