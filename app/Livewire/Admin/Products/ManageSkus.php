<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageSkus extends Component
{
    use WithFileUploads;

    public Product $product;

    public ?ProductDetails $selectedSku = null;
    public bool $isEditMode = false;

    public string $code = '';
    public string $price = '';
    public int $stock = 0;
    public string $options_raw = '';

    public array $images = [];
    public array $new_images = [];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    protected function rules(): array
    {
        $skuId = $this->selectedSku ? $this->selectedSku->id : 'NULL';

        return [
            'code'         => "required|string|max:100|unique:product_details,code,{$skuId}",
            'price'        => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
            'options_raw'  => 'nullable|string',
            'new_images'   => 'nullable|array|max:5',
            'new_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function resetForm()
    {
        $this->reset(['code', 'price', 'stock', 'options_raw', 'images', 'new_images', 'selectedSku', 'isEditMode']);
        $this->resetValidation();
    }

    public function editSku(int $id)
    {
        $this->resetForm();
        $this->selectedSku = ProductDetails::findOrFail($id);
        $this->isEditMode = true;

        $this->code = $this->selectedSku->code;
        $this->price = $this->selectedSku->price;
        $this->stock = $this->selectedSku->stock;
        $this->images = is_array($this->selectedSku->images) ? $this->selectedSku->images : [];

        if (is_array($this->selectedSku->options)) {
            $formatted = [];
            foreach ($this->selectedSku->options as $key => $value) {
                $formatted[] = "{$key}: {$value}";
            }
            $this->options_raw = implode(', ', $formatted);
        }
    }

    public function saveSku()
    {
        $this->validate();

        $optionsArray = [];
        if (!empty($this->options_raw)) {
            foreach (explode(',', $this->options_raw) as $pair) {
                $parts = explode(':', $pair);
                if (count($parts) === 2) {
                    $optionsArray[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        foreach ($this->new_images as $file) {
            if (is_object($file) && method_exists($file, 'store')) {
                $this->images[] = $file->store('products/variants', 'public');
            }
        }

        if ($this->isEditMode) {
            $this->selectedSku->update([
                'code'    => $this->code,
                'price'   => $this->price,
                'stock'   => $this->stock,
                'options' => $optionsArray,
                'images'  => array_values($this->images),
            ]);
            session()->flash('status', 'Variant SKU configuration updated.');
        } else {
            $this->product->productDetails()->create([
                'code'    => $this->code,
                'price'   => $this->price,
                'stock'   => $this->stock,
                'options' => $optionsArray,
                'images'  => array_values($this->images),
            ]);
            session()->flash('status', 'New Variant SKU appended successfully.');
        }

        $this->resetForm();
        $this->product->load('productDetails');
    }

    public function removeExistingImage(int $index): void
    {
        if (!isset($this->images[$index])) {
            return;
        }

        $path = $this->images[$index];

        if (is_string($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeTemporaryImage(int $index): void
    {
        if (isset($this->new_images[$index])) {
            unset($this->new_images[$index]);
            $this->new_images = array_values($this->new_images);
        }
    }

    public function deleteSku(int $id)
    {
        $sku = ProductDetails::findOrFail($id);

        if (is_array($sku->images)) {
            foreach ($sku->images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $sku->delete();
        $this->product->load('productDetails');
        session()->flash('status', 'Variant record wiped from inventory.');
    }

    public function render()
    {
        return view('livewire.admin.products.manage-skus');
    }
}
