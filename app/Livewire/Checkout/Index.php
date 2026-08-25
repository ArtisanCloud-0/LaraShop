<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

use App\Services\Cart\CartService;
use App\Actions\Checkout\ProcessCheckoutAction;

#[Title('Complete your order process')]
#[Layout('layouts.checkout')]
class Index extends Component
{
    public string $name = '';
    public string $email = '';
    public array $cartItems = [];

    public function mount(CartService $cartService)
    {
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }

        // Fetch items via CartService (handles DB cart for Auth, Session for Guests)
        $this->cartItems = $cartService->getItems();
    }

    public function placeOrder()
    {
        // Refresh cart items state prior to checkout execution
        $this->cartItems = resolve(CartService::class)->getItems();

        if (empty($this->cartItems)) {
            session()->flash('error', 'Your shopping bag is empty.');
            return redirect()->route('cart');
        }

        if (!auth()->check()) {
            $this->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
        }

        // Process order with user_id or guest fallback details
        $order = resolve(ProcessCheckoutAction::class)->execute(
            $this->cartItems,
            auth()->id(),
            auth()->check() ? null : [
                'name'  => $this->name,
                'email' => $this->email,
            ]
        );

        // Clear active cart (DB or Session)
        resolve(CartService::class)->clearCart();

        return redirect()->route('order.success', $order->id);
    }

    public function render()
    {
        return view('livewire.checkout.index');
    }
}
