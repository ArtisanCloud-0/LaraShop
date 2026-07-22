<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\On; 
use Livewire\Attributes\Layout; 

use App\Models\Cart As CartModel;
use App\Actions\Cart\RemoveItemFromCartAction;
use App\Actions\Cart\UpdateCartItemQuantityAction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.store')]
class Cart extends Component
{

    public $cartItems = [];

    // Fetch cart items on page load from the database or cart session
    public function mount(): void
    {
        $this->loadCartItems();
    }

    // Load cart items logic
    public function loadCartItems(): void
    {
        // [ 1 ] Check if the user is login or guest user
        if(Auth::check()) {

            $userCart = CartModel::with('items')->where('user_id', Auth::id())->first();
            
            $this->cartItems = $userCart ? $userCart->items->keyBy('id')->toArray() : [];

        } else {
            
            $this->cartItems = Session::get('cart', []);

        }
    }

    // Update Quantity
    public function updateQuantity(int $itemId, int $newQty): void
    {
        resolve(UpdateCartItemQuantityAction::class)->execute($itemId, $newQty);
    }

    // Remove Items
    public function removeItem(int $itemId): void
    {
        resolve(RemoveItemFromCartAction::class)->execute($itemId);

        $this->loadCartItems();
    }

    #[On('cart-updated')]
    public function getCartCountProperty(): int
    {
        if (Auth::check()) {
            return \App\Models\CartItem::whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))->sum('qty');
        }

        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'qty'));
    }

    public function render()
    {
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $this->cartItems));

        return view('livewire.store.cart', [
            'subtotal' => $subtotal
        ]);
    }
}
