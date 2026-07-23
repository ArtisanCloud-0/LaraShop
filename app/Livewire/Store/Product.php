<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Actions\Cart\AddToCartAction;

use App\Models\Product As ProductModel;

#[Layout('layouts.store')]
class Product extends Component
{

    public function addToCart($productId): void
    {
        // [ 1 ] Grap the specific product data
        $product = ProductModel::findOrFail($productId);

        // [ 2 ] Add Product data to the database or session cart
        resolve(AddToCartAction::class)->execute($product);

        // [ 3 ] Update the cart items inthe user view
        $this->dispatch('cart-updated');

        // [ 4 ] Send success message to the user
        session()->flash('status', "{{ $product->name }} added to the bag");
    }

    public function render()
    {
        return view('livewire.store.product', [
            'products' => ProductModel::with(['category', 'productDetails'])->where('is_visible', true)->get()
        ]);
    }
}
