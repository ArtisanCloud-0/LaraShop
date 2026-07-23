<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Actions\Cart\AddToCartAction;
use App\Models\Product;

#[Layout('layouts::store')]
class Welcome extends Component
{

    public function addToCart(int $productId): void
    {
        $product = Product::findOrFail($productId);

        // Execute the action
        resolve(AddToCartAction::class)->execute($product);

        // Dispatch event to update navbar/header cart count badge
        $this->dispatch('cart-updated');

        // Session updating message
        session()->flash('success', "{$product->name} added to your bag!");
    }

    public function render()
    {
        // $res = Product::with('category')->with('productDetails')->get();

        // dd($res);

        return view('livewire.store.welcome', [
            'products' => Product::with('category')->get()
        ]);
    }
}
