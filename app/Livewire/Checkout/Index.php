<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

use App\Services\Cart\CartService;
use App\Actions\Checkout\ProcessCheckoutAction;
use App\Services\Checkout\CheckoutService;

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

        $this->cartItems = $cartService->getItems();
    }

    public function placeOrder(ProcessCheckoutAction $action, CartService $cartService)
    {
        $this->cartItems = $cartService->getItems();

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

        // Dispatch background checkout job
        $action->execute(
            $this->cartItems,
            auth()->id(),
            auth()->check()
                ?
                [
                    'name'  => Auth()->user()?->name,
                    'email' => Auth()->user()?->email,
                    'phone' => Auth()->user()?->phone ?? null,
                ]
                :
                [
                    'name'  => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone ?? null,
                ]
        );

        // Immediately clear cart so user cannot submit twice
        $cartService->clearCart();

        session()->flash('status', 'Your order has been placed successfully!');
        return redirect()->route('order.success', ['orderNumber' => resolve(CheckoutService::class)->getOrderByNumber()?->order_number]);
    }

    public function render()
    {
        return view('livewire.checkout.index');
    }
}
