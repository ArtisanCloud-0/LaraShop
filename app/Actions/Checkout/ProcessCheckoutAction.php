<?php 

namespace App\Actions\Checkout;

use App\Models\OrderLedger;
use App\Services\Checkout\CheckoutService;

class ProcessCheckoutAction
{
    
    public function __construct(protected CheckoutService $checkoutService) {}

    public function execute(array $cartItems, ?int $userId = null): OrderLedger
    {
        return $this->checkoutService->processCheckout($cartItems, $userId);
    }

}