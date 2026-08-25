<?php

namespace App\Livewire\Checkout;

use App\Models\OrderLedger;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.checkout')]
class OrderSuccess extends Component
{
    public OrderLedger $order;

    public function mount(int $orderId)
    {
        $query = OrderLedger::with(['items.productDetails.product'])
            ->where('id', $orderId);

        // Security check: restrict authenticated users to their own orders
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        $this->order = $query->firstOrFail();
    }

    public function render()
    {
        return view('livewire.checkout.order-success');
    }
}
