<?php

namespace App\Livewire\Store\Navigation;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Cart;

class CartCounter extends Component
{
    // Listen for the event dispatched from product card or cart page
    #[On('cart-updated')] 
    public function updateCount(): void
    {
        // Livewire re-renders automatically when an action/event handler fires
    }
    
    private function getCartCount(): int
    {
        if (Auth::check()) {
            $userCart = Cart::withSum('items', 'quantity')
                ->where('user_id', Auth::id())
                ->first();

            // Corrected attribute name: items_sum_quantity
            return (int) ($userCart->items_sum_quantity ?? 0);
        }

        $cart = Session::get('cart', []);
        
        // Sum total quantities from session array
        return (int) array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.store.navigation.cart-counter', [
            'count' => $this->getCartCount()
        ]);
    }
}