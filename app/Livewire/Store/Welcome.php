<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Actions\Cart\AddToCartAction;
use App\Models\Product;
use App\Models\ProductDetails;

#[Layout('layouts::store')]
class Welcome extends Component
{

    public function addToCart(int $productId): void
    {

        // Grap the specific product data
        $variant = ProductDetails::findOrFail($productId);

        // Execute the action
        resolve(AddToCartAction::class)->execute($variant, 1);

        // Dispatch event to update navbar/header cart count badge
        $this->dispatch('cart-updated');
        
        // Session updating message
        session()->flash('success', "1 item added to your bag!");
        
    }

    public function render()
    {
        return view('livewire.store.welcome', [
            'products' => Product::with(['category', 'productDetails'])->where('is_visible', true)->get()
        ]);
    }
}
