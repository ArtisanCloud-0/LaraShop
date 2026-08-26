<?php

namespace App\Actions\Checkout;

use App\Jobs\ProcessCheckoutJob;
use App\Models\OrderLedger;
use App\Services\Checkout\CheckoutService;

class ProcessCheckoutAction
{

    public function __construct(protected CheckoutService $checkoutService) {}

    public function execute(array $cartItems, ?int $userId = null, ?array $guestInfo = null): void
    {
        // return $this->checkoutService->processCheckout($cartItems, $userId, $guestInfo);
        ProcessCheckoutJob::dispatch($cartItems, $userId, $guestInfo);
    }
}
