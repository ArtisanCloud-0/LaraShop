<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\Product;

use Livewire\WithPagination;

#[Title('Products Management')]
class Index extends Component
{

    use WithPagination;

    /**
     * Delete a product record securely. 
     * Foreign key restrictOnDelete() prevents wiping if attached elsewhere.
     */
    public function deleteProduct(int $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            $this->dispatch('toast', message: 'Product record successfully removed from registry.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Unable to delete product.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.products.index', [
            // Eager load category and skus relations to completely avoid N+1 query bottle-necks
            'products' => Product::with(['category', 'productDetails'])
                ->withSum('productDetails as total_stock', 'stock')
                ->latest()
                ->paginate(5)
        ]);
    }
}
