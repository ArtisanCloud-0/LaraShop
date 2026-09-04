<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.store')]
#[Title('My Orders')]
class ShowOrders extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    private function getOrdersQuery()
    {
        return auth()->user()
            ->orders()
            ->with(['items.productDetails.product'])
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->when(trim($this->search) !== '', function ($query) {
                $term = '%' . trim($this->search) . '%';
                $query->where(function ($q) use ($term) {
                    $q->where('order_number', 'like', $term)
                        ->orWhereHas('items.productDetails.product', function ($prodQuery) use ($term) {
                            $prodQuery->where('name', 'like', $term);
                        });
                });
            });
    }

    public function exportCsv()
    {
        $orders = $this->getOrdersQuery()->latest()->get();

        $filename = 'orders_export_' . now()->format('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Order #', 'Date Placed', 'Status', 'Total Price ($)', 'Total Items']);

            foreach ($orders as $order) {
                $status = $order->status instanceof \BackedEnum ? $order->status->value : $order->status;

                fputcsv($file, [
                    '#' . $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    strtoupper($status ?? 'PENDING'),
                    number_format($order->total_amount / 100, 2, '.', ''),
                    $order->items->sum('quantity'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $orders = $this->getOrdersQuery()->latest()->paginate(10);

        return view('livewire.store.show-orders', [
            'orders' => $orders,
        ]);
    }
}
