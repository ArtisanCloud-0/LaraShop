<?php

namespace App\Livewire\Admin\Orders;

use App\Models\OrderLedger As Order;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

use App\Services\Order\OrderService;

use App\Actions\Order\UpdateOrderStatusAction;

#[Title('Orders Overview & Management')]
class Index extends Component
{

    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public ?Order $selectedOrder = null;
    public bool $showDetailsModal = false;

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    public function viewOrder(int $orderId)
    {
        $this->selectedOrder = Order::with(['user', 'items'])->findOrFail($orderId);
        $this->showDetailsModal = true;
    }

    public function updateStatus(int $orderId, string $status)
    {
        $order = Order::findOrFail($orderId);

        resolve(UpdateOrderStatusAction::class)->execute($order, $status);

        if ($this->selectedOrder && $this->selectedOrder->id === $orderId) {
        
            $this->selectedOrder->refresh();
        
        }

        session()->flash('status', "Order #{$order->order_number} status updated to " . ucfirst($status));
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedOrder = null;
    }

    public function render()
    {
        return view('livewire.admin.orders.index', [
            'orders' => resolve(OrderService::class)->getOrders($this->search, $this->statusFilter),
        ]);
    }
}
