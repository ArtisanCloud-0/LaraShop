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


    /*
    |--------------------------------------------------------------------------
    | Reset pagination whenever a filter changes
    |--------------------------------------------------------------------------
    */

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function updatingProductLines(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedSizes(): void
    {
        $this->resetPage();
    }

    public function updatingSortBy(): void
    {
        $this->resetPage();
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    public function resetFilters(): void
    {
        $this->reset([
            'category',
            'productLines',
            'selectedSizes',
            'sortBy',
        ]);

        $this->sortBy = 'newest';

        $this->resetPage();
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Size
    |--------------------------------------------------------------------------
    */

    public function toggleSize(string $size): void
    {
        if (in_array($size, $this->selectedSizes, true)) {

            $this->selectedSizes = array_values(
                array_diff(
                    $this->selectedSizes,
                    [$size]
                )
            );
        } else {

            $this->selectedSizes[] = $size;
        }

        $this->resetPage();
    }


    /*
    |--------------------------------------------------------------------------
    | Add Product Variant To Cart
    |--------------------------------------------------------------------------
    */

    public function addToCart(int $productDetailsId): void
    {
        $variant = ProductDetails::findOrFail($productDetailsId);

        resolve(AddToCartAction::class)
            ->execute($variant->id, 1);

        $this->dispatch('cart-updated');

        $this->dispatch(
            'toast',
            message: 'Item added to cart.',
            type: 'success'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Products Query
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $query = ProductModel::query()
            ->with([
                'category.parent',
                'productDetails',
            ])
            ->where('is_visible', true);


        /*
        |--------------------------------------------------------------------------
        | Main Category
        |--------------------------------------------------------------------------
        */

        $query->when($this->category, function ($q) {

            $q->whereHas('category', function ($catQuery) {

                $catQuery
                    ->where('slug', $this->category)

                    ->orWhereHas('parent', function ($parentQuery) {
                        $parentQuery->where(
                            'slug',
                            $this->category
                        );
                    });
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Product Line
        |--------------------------------------------------------------------------
        |
        | Product Line = Parent Category.
        |
        */

        $query->when(!empty($this->productLines), function ($q) {

            $q->whereHas('category', function ($catQuery) {

                $catQuery
                    ->whereIn(
                        'slug',
                        $this->productLines
                    )

                    ->orWhereHas('parent', function ($parentQuery) {

                        $parentQuery->whereIn(
                            'slug',
                            $this->productLines
                        );
                    });
            });
        });


        /*
        |--------------------------------------------------------------------------
        | Size
        |--------------------------------------------------------------------------
        |
        | Database JSON:
        |
        | {
        |     "Color": "Green",
        |     "Size": "M"
        | }
        |
        */

        $query->when(!empty($this->selectedSizes), function ($q) {

            $q->whereHas(
                'productDetails',
                function ($detailQuery) {

                    $detailQuery->where(
                        function ($subQuery) {

                            foreach (
                                $this->selectedSizes
                                as $size
                            ) {

                                $subQuery->orWhereRaw(
                                    "LOWER(JSON_UNQUOTE(JSON_EXTRACT(options, '$.Size'))) = ?",
                                    [strtolower($size)]
                                );
                            }
                        }
                    );
                }
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        match ($this->sortBy) {

            'price_asc' => $query->orderBy(
                ProductDetails::select('price')
                    ->whereColumn(
                        'product_id',
                        'products.id'
                    )
                    ->orderBy('price', 'asc')
                    ->limit(1),
                'asc'
            ),

            'price_desc' => $query->orderBy(
                ProductDetails::select('price')
                    ->whereColumn(
                        'product_id',
                        'products.id'
                    )
                    ->orderBy('price', 'desc')
                    ->limit(1),
                'desc'
            ),

            default => $query->latest(),
        };


        /*
        |--------------------------------------------------------------------------
        | Product Line Choices
        |--------------------------------------------------------------------------
        */

        $availableCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_visible', true)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('livewire.store.product', [

            'products' => $query->paginate(8),

            'activeCategory' => $this->category
                ? Category::where(
                    'slug',
                    $this->category
                )->first()
                : null,

            'availableCategories' => $availableCategories,

        ]);
    }
}
