<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;

use App\Models\Product;
use App\Models\ProductDetails;

class ManageSkus extends Component
{

    public Product $product;
    
    // Form Input Properties
    public ?ProductDetails $selectedSku = null; // Tracks if we are editing an existing SKU
    public bool $isEditMode = false;
    
    public string $code = '';
    public string $price = ''; // Handled as decimal input, model casts to integer cents
    public int $stock = 0;
    public string $options_raw = ''; // String proxy for the dynamic options JSON input

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    protected function rules(): array
    {
        $skuId = $this->selectedSku ? $this->selectedSku->id : 'NULL';
        return [
            'code'        => "required|string|max:100|unique:product_details,code,{$skuId}",
            'price'       => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'options_raw' => 'nullable|string',
        ];
    }

    /**
     * Clear form states back to baseline
     */
    public function resetForm()
    {
        $this->reset(['code', 'price', 'stock', 'options_raw', 'selectedSku', 'isEditMode']);
        $this->resetValidation();
    }

    /**
     * Hydrate form inputs for editing an existing SKU row
     */
    public function editSku(int $id)
    {
        $this->resetForm();
        $this->selectedSku = ProductDetails::findOrFail($id);
        $this->isEditMode = true;

        $this->code = $this->selectedSku->code;
        $this->price = $this->selectedSku->price; // Automatically decoded via model attribute cast
        $this->stock = $this->selectedSku->stock;
        
        // Convert array layout back to comma-separated text ("Color: Slate, Size: XL")
        if (is_array($this->selectedSku->options)) {
            $formatted = [];
            foreach ($this->selectedSku->options as $key => $value) {
                $formatted[] = "{$key}: {$value}";
            }
            $this->options_raw = implode(', ', $formatted);
        }
    }

    /**
     * Unified Save Action (Handles both Create and Update operations)
     */
    public function saveSku()
    {
        $this->validate();

        // Convert the user raw string string format into an associative options array layout
        $optionsArray = [];
        if (!empty($this->options_raw)) {
            foreach (explode(',', $this->options_raw) as $pair) {
                $parts = explode(':', $pair);
                if (count($parts) === 2) {
                    $optionsArray[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        if ($this->isEditMode) {
            $this->selectedSku->update([
                'code'    => $this->code,
                'price'   => $this->price, // Set mutator parses this to integer cents automatically
                'stock'   => $this->stock,
                'options' => $optionsArray,
            ]);
            session()->flash('status', 'Variant SKU configuration updated.');
        } else {
            $this->product->productDetails()->create([
                'code'    => $this->code,
                'price'   => $this->price,
                'stock'   => $this->stock,
                'options' => $optionsArray,
            ]);
            session()->flash('status', 'New Variant SKU appended successfully.');
        }

        $this->resetForm();
        $this->product->load('productDetails'); // Refresh relationships
    }

    /**
     * Purge a target SKU variant record instantly
     */
    public function deleteSku(int $id)
    {
        ProductDetails::findOrFail($id)->delete();
        $this->product->load('productDetails');
        session()->flash('status', 'Variant record wiped from inventory.');
    }

    public function render()
    {
        return view('livewire.admin.products.manage-skus');
    }
}
