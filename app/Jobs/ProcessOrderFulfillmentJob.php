<?php

namespace App\Jobs;

use App\Models\OrderLedger as Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrderFulfillmentJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $this->order->loadMissing('items.product');

        foreach ($this->order->items as $item) {
            if ($item->product) {
                // Decrement stock dynamically
                $item->product->decrement('quantity', $item->quantity);

                // Low stock threshold check
                if ($item->product->quantity <= 3) {
                    Log::warning("Low Stock Alert: Product #{$item->product->id} ({$item->product->name}) has {$item->product->quantity} remaining.");
                }
            }
        }

        Log::info("Fulfillment processing completed for Order #{$this->order->order_number}");
    }
}
