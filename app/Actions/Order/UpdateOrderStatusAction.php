<?php

namespace App\Actions\Order;

use App\Models\OrderLedger As Order;

class UpdateOrderStatusAction
{
    
    public function execute(Order $order, OrderStatus|string $status): Order
    {
        $order->update([
            'status' => $status,
        ]);

        return $order;
    }

}
