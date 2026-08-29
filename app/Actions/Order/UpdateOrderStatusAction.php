<?php

namespace App\Actions\Order;

use App\Models\OrderLedger as Order;
use App\Enums\OrderStatus;
use App\Jobs\SendOrderStatusUpdatedEmailJob;

class UpdateOrderStatusAction
{
    public function execute(Order $order, OrderStatus|string $status): Order
    {
        $previousStatus = $order->status->value ?? (string) $order->status;

        $order->update([
            'status' => $status,
        ]);

        // Dispatch background job for admin status update
        SendOrderStatusUpdatedEmailJob::dispatch($order, $previousStatus)->onQueue('high');

        return $order;
    }
}
