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

    public function mount()
    {
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }
    }

    public function placeOrder(ProcessCheckoutAction $action, CartService $cartService)
    {
        $cartItems = $cartService->getItems();

        if (empty($cartItems)) {
            session()->flash('error', 'Your shopping bag is empty.');
            return redirect()->route('cart');
        }

        if (!auth()->check()) {
            $this->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
        }

        // Pass nullable user ID (null for guests)
        $userId = auth()->id();

        // Process order
        $order = $action->execute($cartItems, $userId);

        // Clear session or DB cart
        $cartService->clearCart();

        return redirect()->route('order.success', $order->id);
    }

    public function render()
    {
        return view('livewire.checkout.index');
    }
}