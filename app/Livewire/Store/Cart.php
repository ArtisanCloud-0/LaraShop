<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

use App\Models\Cart as CartModel;
use App\Models\CartItem as CartItemModel;
use App\Actions\Cart\RemoveItemFromCartAction;
use App\Actions\Cart\UpdateCartItemQuantityAction;

use App\Services\Cart\CartService;

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
            // 1. Eager-load variant AND its nested parent product
            $userCart = CartModel::with(['items.productDetails.product'])
                ->where('user_id', Auth::id())
                ->first();

            if ($userCart) {
                // 2. Map database items to array
                $this->cartItems = $userCart->items->mapWithKeys(function (CartItemModel $item) {
                    // Match the relationship property name defined in CartItemModel
                    $variant = $item->productDetails;
                    $product = $variant?->product;

                    return [
                        $item->product_details_id => [
                            'product_details_id' => $item->product_details_id,
                            'name'               => $product?->name ?? 'Product',
                            'options'            => $variant?->options ?? [],
                            'price'              => $variant?->price ?? 0,
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
        try {
            resolve(UpdateCartItemQuantityAction::class)
                ->execute($variantId, $newQty); // Update the quantity of the cart item

            $this->loadCartItems(); // Refresh the cart items after updating the quantity

            $this->dispatch('cart-updated'); // Notify the navbar counter to re-render

            $this->dispatch('toast', message: 'Cart updated successfully.', type: 'success'); // Flash success message
        } catch (\InvalidArgumentException $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error'); // Flash error message if the quantity is invalid
        }
    }

    public function removeItem(int $variantId): void
    {
        resolve(RemoveItemFromCartAction::class)->execute($variantId);
        $this->loadCartItems();

        // Notify the navbar counter to re-render
        $this->dispatch('cart-updated');

        $this->dispatch('toast', message: 'Item removed from cart successfully.', type: 'success'); // Flash success message
    }

    #[On('cart-updated')]
    public function handleCartUpdated(): void
    {
        $this->loadCartItems();
    }

    public function proceedToCheckout(CartService $cartService)
    {
        $items = $cartService->getItems();

        if (empty($items)) {
            $this->dispatch('toast', message: 'Your shopping bag is empty.', type: 'error');
            return;
        }

        return redirect()->route('checkout');
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
