<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Actions\Cart\AddToCartAction;

use App\Models\Product As ProductModel;
use App\Models\ProductDetails;

#[Layout('layouts.store')]
class Product extends Component
{

    public function addToCart(int $productDetailsId): void
    {
        // 1. Fetch the variant (product_details) by ID instead of Product
        $variant = ProductDetails::findOrFail($productDetailsId);

        // 2. Execute action to add variant to cart
        resolve(AddToCartAction::class)->execute($variant, 1);

        // 3. Dispatch event to update navbar counter & other components
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.store.product', [
            'products' => ProductModel::with(['category', 'productDetails'])->where('is_visible', true)->get()
        ]);
    }
}
