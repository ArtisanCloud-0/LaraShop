<?php

namespace App\Services\Order;

use App\Models\OrderLedger As Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function getOrders(string $search = '', string $status = 'all', int $perPage = 10): LengthAwarePaginator
    {
        return Order::query()
            ->with(['user', 'items'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($u) use ($search) {
                          $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate($perPage);
    }
}
