<?php

namespace App\Livewire\Admin\Products;

use App\Actions\Product\UpsertProductAction;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upsert extends Component
{
    use WithFileUploads;

    public ?Product $product = null;
    public bool $isEditMode = false;

    public string $name = '';
    public ?int $category_id = null;
    public string $description = '';
    public bool $is_visible = true;

    public ?string $cover_image = null;
    public mixed $new_cover_image = null;

    protected function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'min:3', 'max:150'],
            'category_id'      => ['required', 'integer', 'exists:categories,id'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'is_visible'       => ['boolean'],
            'new_cover_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function mount(?Product $product = null): void
    {
        if ($product?->exists) {
            $this->product = $product;
            $this->isEditMode = true;

            $this->name = $product->name;
            $this->category_id = $product->category_id;
            $this->description = $product->description ?? '';
            $this->is_visible = (bool) $product->is_visible;
            $this->cover_image = $product->cover_image;
            $this->dispatch('toast', message: 'Loading existing product configuration complete.', type: 'info');
        }
    }

    public function save(UpsertProductAction $action)
    {
        $this->validate();

        try {
            $coverImagePath = $this->cover_image;

            if ($this->new_cover_image && method_exists($this->new_cover_image, 'store')) {
                if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
                    Storage::disk('public')->delete($this->cover_image);
                }
                $coverImagePath = $this->new_cover_image->store('products/covers', 'public');
            }

            $payload = [
                'name'        => $this->name,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'is_visible'  => $this->is_visible,
                'cover_image' => $coverImagePath,
            ];

            $this->product = $action->execute($payload, $this->product);

            $this->dispatch('toast', message: $this->isEditMode ? 'Product updated successfully.' : 'Product created successfully.', type: 'success');

            return redirect()->route('panel.products');
        } catch (\Throwable $exception) {
            report($exception);
            $this->dispatch('toast', message: 'Unable to save product dataset. Please check inputs and retry.', type: 'error');
        }
    }

    public function removeCoverImage(): void
    {
        if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
            Storage::disk('public')->delete($this->cover_image);
        }

        $this->cover_image = null;
        $this->new_cover_image = null;

        if ($this->product?->exists) {
            $this->product->update(['cover_image' => null]);
        }
        $this->dispatch('toast', message: 'Cover image removed.', type: 'info');
    }

    #[Title('Product Upsert Manager')]
    public function render()
    {
        return view('livewire.admin.products.upsert', [
            'categories' => Category::query()
                ->where('is_visible', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
