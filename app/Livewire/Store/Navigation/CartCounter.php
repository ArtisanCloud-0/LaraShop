<?php

namespace App\Livewire\Store\Navigation;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Cart;

class CartCounter extends Component
{

    // Listen for the event dispatched from the product card
    #[On('cart-updated')] 
    public function updateCount(): void
    {
        // Re-render component on event
    }
    
    private function getCartCount(): int
    {
        if (Auth::check()) {
            $userCart = Cart::withSum('items', 'qty')
                ->where('user_id', Auth::id())
                ->first();

            return $userCart->items_sum_qty ?? 0;
        }

        $cart = Session::get('cart', []);
        
        return array_sum(array_column($cart, 'qty'));
    }

    public function render()
    {
        $count = $this->getCartCount();

        return view('livewire.store.navigation.cart-counter', [
            'count' => $count
        ]);
    }
}
