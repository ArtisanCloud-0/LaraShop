<?php

namespace App\Services\Order;

use App\Models\OrderLedger as Order;
use App\Jobs\SendOrderConfirmationEmailJob;
use App\Jobs\ProcessOrderFulfillmentJob;
use Illuminate\Support\Facades\DB;

class CheckoutOrchestrationService
{
    public function completeCheckout(array $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            // 1. Create order record & copy cart items (Synchronous)
            $order = Order::create($orderData);

            // 2. Dispatch background jobs off to the database queue (Asynchronous)
            SendOrderConfirmationEmailJob::dispatch($order)->onQueue('high');
            ProcessOrderFulfillmentJob::dispatch($order)->onQueue('default');

            return $order;
        });
    }
}
