<?php

namespace App\Livewire\Checkout;

use App\Models\OrderLedger;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.checkout')]
#[Title('Order Success | LaraShop - Your One-Stop Shop for All Your Needs')]
class OrderSuccess extends Component
{
    public OrderLedger $order;

    public function mount(string $orderNumber, string $publicToken): void
    {
        $query = OrderLedger::with(['items.productDetails.product',]) // Eager load related models to avoid N+1 query issues
            ->where('order_number', $orderNumber) // Filter by the provided order number
            ->where('public_token', $publicToken); // Ensure the public token matches for security

        // Authenticated customers can only view their own orders.
        if (auth()->check()) { // Check if the user is authenticated
            $query->where('user_id', auth()->id()); // Filter the order by the authenticated user's ID
        }

        $this->order = $query->firstOrFail(); // Retrieve the order or fail if not found
    }

    public function render()
    {
        return view('livewire.checkout.order-success');
    }
}
