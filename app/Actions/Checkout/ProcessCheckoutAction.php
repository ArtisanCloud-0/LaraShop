<?php

namespace App\Actions\Checkout;

use App\Models\OrderLedger;
use App\Services\Checkout\CheckoutService;

class ProcessCheckoutAction
{
    public function __construct(
        protected CheckoutService $checkoutService
    ) {} // Inject the CheckoutService dependency into the ProcessCheckoutAction class

    /**
     * Process the checkout immediately.
     *
     * The order must be successfully created before the caller
     * clears the cart or redirects the customer.
     */
    public function execute(
        array $cartItems,
        ?int $userId = null,
        array $customerData = []
    ): OrderLedger { // Execute the checkout process and return the created OrderLedger instance
        return $this->checkoutService->process( // Call the process method of the CheckoutService to handle the checkout logic
            $userId,
            $cartItems,
            $customerData
        );
    }
}
