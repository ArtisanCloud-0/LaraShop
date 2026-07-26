<?php

namespace App\Livewire\Store;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Product;
use App\Models\ProductDetails As ProductVariant;

use App\Actions\Cart\AddToCartAction;

#[Layout('layouts.store')]
class ProductDetails extends Component
{

    /*
    *===========================
    * === Required Variables ===
    *===========================
    **/
    // [ 1 ] The product details
    public Product $product;

    // [ 2 ] Array holding all attributes keys and all the available values
    // Ex => ['color' => ['red', 'green'], 'size' => ['XL', 'M']]
    public array $variantAttributes = [];

    // [ 3 ] Track current selected values from the UI
    // Ex => ['color' => 'yellow', 'size' => 'XXL']
    public array $selectedOptions = [];

    // [ 4 ] The current active variant record
    public ?ProductVariant $activeVariant = null;

    // [ 5 ] The Quantity of the item been selected
    public int $quantity = 1;

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    *==================================
    * === Mount the Product Details ===
    *==================================
    **/
    public function mount(Product $product): void
    {
        // [ 1 ] Eager lodaing the variants
        $this->product = $product->load(['category', 'productDetails']);

        // [ 2 ] Extract variant attributes
        $this->extractVariantAttributes();

        // [ 3 ] Set Default Selection
        $this->setDefaultSelections();

        // [ 4 ] Handle active variant
        $this->resolveActiveVariant();
    }

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    * =================================
    * === Extracting variant attrib ===
    * =================================
    *
    * == Parse all JSON options across variants to extract dynamic attributes & available values ==
    **/
    public function extractVariantAttributes(): void
    {
        foreach ($this->product->ProductDetails as $variant) {
            
            // [ 1 ] Check if their is no variant
            if(!is_array($variant->options)) {
                continue;
            }

            // [ 2 ] Creates the variant attribute list
            foreach ($variant->options as $key => $value) {

                // [ 2-1 ] If the attribute key is not exsist then keep it empty
                if(!isset($this->variantAttributes[$key])) {
                    $this->variantAttributes[$key] = []; 
                } 

                // [ 2-2 ] The value is not exsist in the attribute list then added it
                if(!in_array($value, $this->variantAttributes[$key], true)) {
                    $this->variantAttributes[$key][] = $value;
                }

            }
        }
    }

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    * =======================================
    * === Make defaul selection in the UI ===
    * =======================================
    *
    * == Pre-select the first available variant options on initial load 
    **/
    public function setDefaultSelections(): void
    {
        // [ 1 ] Holding the first value from product variant model
        $defaultVariant = $this->product->ProductDetails->first();

        // [ 2 ] Check if their is at least one variant and the variant data is an array
        if ($defaultVariant && is_array($defaultVariant->oprions)) {
            // [ 3 ] Put the values in the UI
            $this->selectedOptions = $defaultVariant->options;
        }
    }

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    * ===================================================
    * === Select one variant to be the default option ===
    * ===================================================
    *
    * == Find the exact ProductVariant matching the selected choices
    **/
    public function resolveActiveVariant(): void
    {
        $this->activeVariant = $this->product->ProductDetails->first(function ($variant) {
            
            // [ 1 ] If the selected variant is not an array return error feedback
            if(!is_array($variant->options)) {
                return false;
            }

            // [ 2 ] Compare array key-value pairs
            return empty(array_diff_assoc($this->selectedOptions, $variant->options)) && empty(array_diff_assoc($variant->options, $this->selectedOptions));

        });
    }

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    * =================================
    * === Automatic updating the UI ===
    * =================================
    *
    * == Tells Livewire to update UI when an update occurs
    **/
    public function updatedSelectedOptions(): void
    {
        $this->resolveActiveVariant();
    }

    //====================================================================================================== 
    //====================================================================================================== 

    /*
    * ===================
    * === Cart Action ===
    * ===================
    *
     * Add selected variant to cart logic.
    **/
    public function addToCart(): void
    {
        // [ 1 ] Return error if their is no variant or the stock is empty
        if (!$this->activeVariant || $this->activeVariant->stock < $this->quantity) {
            return;
        }

        // [ 2 ] Add items to User || Guest cart
        resolve(AddToCartAction::class)->execute($this->activeVariant, $this->quantity);

        // [ 3 ] Refreshing the cart items in cart.php livewire class inside store folder
        $this->dispatch('cart-updated');
    }

    /*
    * ================================
    * === Rendering the product UI ===
    * ================================
    **/
    public function render()
    {
        return view('livewire.store.product-details');
    }
}
