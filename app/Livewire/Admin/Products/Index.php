<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetails;

use Livewire\WithPagination;

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

            session()->flash('status', 'Product record successfully removed from registry.');
        } catch (\Exception $e) {
            $this->addError('delete_failure', 'Cannot delete product: Verify that no orders or dependencies rely on this record layout.');
        }
    }

    public function render()
    {
        return view('livewire.admin.products.index', [
            // Eager load category and skus relations to completely avoid N+1 query bottle-necks
            'products' => Product::with(['category', 'productDetails'])
                ->latest()
                ->paginate(10)
            // 'products' => Product::paginate(10)
        ]);
    }
}
