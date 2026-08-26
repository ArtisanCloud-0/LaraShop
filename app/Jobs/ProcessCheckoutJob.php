<?php

namespace App\Jobs;

use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCheckoutJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $cartItems,
        public ?int $userId = null,
        public ?array $guestInfo = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CheckoutService $checkoutService, CartService $cartService): void
    {
        // Execute checkout transaction safely in queue worker
        $order = $checkoutService->processCheckout($this->cartItems, $this->userId, $this->guestInfo);
    }
}
