<?php

namespace App\Jobs;

use App\Models\OrderLedger as Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderStatusUpdatedEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public Order $order,
        public string $previousStatus
    ) {}

    public function handle(): void
    {
        $this->order->loadMissing('user');
        $customerEmail = $this->order->user->email ?? $this->order->guest_email ?? 'guest@example.com';

        $statusLabel = is_object($this->order->status) && method_exists($this->order->status, 'label')
            ? $this->order->status->label()
            : (string) $this->order->status;

        Log::info("Order Status Notification Sent to {$customerEmail}: Order #{$this->order->order_number} changed from '{$this->previousStatus}' to '{$statusLabel}'");
    }
}
