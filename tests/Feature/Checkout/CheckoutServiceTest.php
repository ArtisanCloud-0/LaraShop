<?php

use App\Enums\OrderStatus;
use App\Models\ProductDetails;
use App\Services\Checkout\CheckoutService;

it('creates an order and decreases inventory during checkout', function () {
    $productDetails = ProductDetails::factory()->create([
        'price' => 25.00,
        'stock' => 10,
    ]);

    $service = app(CheckoutService::class);

    $order = $service->process(
        userId: null,
        items: [
            [
                'product_details_id' => $productDetails->id,
                'quantity' => 2,
            ],
        ],
        customerData: [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
        ],
    );

    expect($order)
        ->toBeInstanceOf(\App\Models\OrderLedger::class)
        ->and($order->customer_name)
        ->toBe('John Doe')
        ->and($order->customer_email)
        ->toBe('john@example.com')
        ->and($order->total_amount)
        ->toBe(5000)
        ->and($order->status)
        ->toBe(OrderStatus::PENDING);

    expect($order->items)
        ->toHaveCount(1);

    $orderItem = $order->items->first();

    expect($orderItem->product_details_id)
        ->toBe($productDetails->id)
        ->and($orderItem->quantity)
        ->toBe(2)
        ->and($orderItem->price)
        ->toBe(2500)
        ->and($orderItem->subtotal)
        ->toBe(5000);

    expect($productDetails->fresh()->stock)
        ->toBe(8);
});

it('rejects checkout when the cart is empty', function () {
    $service = app(CheckoutService::class);

    expect(fn() => $service->process(
        userId: null,
        items: [],
        customerData: [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
        ],
    ))->toThrow(\InvalidArgumentException::class);

    expect(\App\Models\OrderLedger::count())
        ->toBe(0);
});
