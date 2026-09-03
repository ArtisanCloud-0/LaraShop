<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Actions\Cart\AddToCartAction;
use App\Models\Product as ProductModel;
use App\Models\ProductDetails;
use App\Models\Category;

#[Layout('layouts.store')]
class Product extends Component
{
    use WithPagination;

    #[Url]
    public string $category = '';

    #[Url]
    public array $productLines = [];

    #[Url]
    public array $selectedSizes = [];

    #[Url]
    public string $sortBy = 'newest';

    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingProductLines()
    {
        $this->resetPage();
    }
    public function updatingSelectedSizes()
    {
        $this->resetPage();
    }
    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['category', 'productLines', 'selectedSizes', 'sortBy']);
        $this->resetPage();
    }

    public function toggleSize(string $size): void
    {
        if (in_array($size, $this->selectedSizes)) {
            $this->selectedSizes = array_values(array_diff($this->selectedSizes, [$size]));
        } else {
            $this->selectedSizes[] = $size;
            $this->selectedSizes = array_values($this->selectedSizes);
        }
        $this->resetPage();
    }

    public function addToCart(int $productDetailsId): void
    {
        $variant = ProductDetails::findOrFail($productDetailsId);
        resolve(AddToCartAction::class)->execute($variant->id, 1);
        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: 'Item added to cart.', type: 'success');
    }

    public function render()
    {
        $query = ProductModel::query()
            ->with(['category', 'productDetails'])
            ->where('is_visible', true);

        // Filter by main category from URL
        $query->when($this->category, function ($q) {
            $q->whereHas('category', function ($catQuery) {
                $catQuery->where('slug', $this->category)
                    ->orWhereHas('parent', fn($pq) => $pq->where('slug', $this->category));
            });
        });

        // Filter by Product Line (Matches both slug and name to prevent UI mismatches)
        $query->when(!empty($this->productLines), function ($q) {
            $q->whereHas('category', function ($catQuery) {
                $catQuery->whereIn('slug', $this->productLines)
                    ->orWhereIn('name', $this->productLines);
            });
        });

        // Filter by Sizes stored in the JSON options column (Handles all JSON quoting variants)
        $query->when(!empty($this->selectedSizes), function ($q) {
            $q->whereHas('productDetails', function ($detailQuery) {
                $detailQuery->where(function ($sub) {
                    foreach ($this->selectedSizes as $size) {
                        $sub->orWhere('options->size', $size)
                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(options, '$.size'))) = ?", [strtolower($size)]);
                    }
                });
            });
        });

        // Sorting Logic
        match ($this->sortBy) {
            'price_asc'  => $query->orderBy(
                ProductDetails::select('price')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price', 'asc')
                    ->limit(1),
                'asc'
            ),
            'price_desc' => $query->orderBy(
                ProductDetails::select('price')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price', 'desc')
                    ->limit(1),
                'desc'
            ),
            default      => $query->latest(),
        };

        $availableCategories = Category::whereNull('parent_id')->where('is_visible', true)->get();

        return view('livewire.store.product', [
            'products'            => $query->paginate(12),
            'activeCategory'      => $this->category ? Category::where('slug', $this->category)->first() : null,
            'availableCategories' => $availableCategories,
        ]);
    }
}
