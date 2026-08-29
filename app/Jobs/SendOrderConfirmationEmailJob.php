<?php

namespace App\Jobs;

use App\Models\OrderLedger as Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderConfirmationEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        // Load items and user relation safely
        $this->order->loadMissing(['user', 'items.product']);

        $customerEmail = $this->order->user->email ?? $this->order->guest_email ?? 'guest@example.com';

        // Simulate async email generation & logging
        Log::info("Sending Order Confirmation Email to: {$customerEmail}", [
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
            'items_count'  => $this->order->items->count(),
        ]);
    }
}
