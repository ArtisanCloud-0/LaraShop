<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;                                         // Inhert Main Livewire Component
use Livewire\WithFileUploads;                                   // Activate files uploads
use Livewire\Attributes\Title;                                  // Give the Page a Title
use Livewire\Attributes\Validate;                               // Call the validator to validate the data

use App\Models\Category;                                        // Call Category Database Model
use App\Models\Product;                                         // Call Product Database Model
use App\Actions\Product\UpsertProductAction;                    // Call the action to insert or update products data

class Upsert extends Component
{

    use WithFileUploads;

    /*
    * ===============================
    * ===== Variable Declartion =====
    * ===============================
    **/
    public ?Product $product = null;                            // Create an emtpy instance of product model
    public bool $isEditMode = false;                            // Control which operation to be done [ insert || Update ]

    public string $name = '';                                   // The name of the product
    public ?int $category_id = null;                            // Which category this product belongs to
    public string $descripiton = '';                            // Match migration spelling
    public bool $is_visible = true;                             // Control if the product will be shown in the public view
    public array $images = [];                                  // Handled as an array before JSON storage casting
    public array $new_images = [];                              // Temporary storage file array for new uploads

    /* 
    * =======================================================
    * == Mount the required data when the action is update ==
    * =======================================================
    **/
    public function mount(?Product $product = null)
    {
        if($product && $product->exists) {                      // If the model is provided the it's update process
            $this->product = $product;                          // Current product 
            $this->isEditMode = true;                           // Turn on form for updating
            $this->name = $product->name;                       // Product name
            $this->category_id = $product->category_id;         // Product category
            $this->descripiton = $product->descripiton ?? '';   // Product description
            $this->is_visible = $product->is_visible;           // Is it visible or not
            $this->images = $product->images ?? [];             // Product main image and thumbs
        } else {}
    }

    /* 
    * =========================================
    * ==== Validation Rules from user form ====
    * =========================================
    **/
    protected function rules(): array
    {
        return [
            'name'         => 'required|string|min:3|max:150',
            'category_id'  => 'required|integer|exists:categories,id',
            'descripiton'  => 'nullable|string|max:2000',
            'is_visible'   => 'boolean',
            'new_images.*' => 'nullable|image|max:2048', // Validation: Max 2MB per image
        ];
    }

    public function save(UpsertProductAction $action, ?Product $product = null)
    {
        // [ 1 ] Validate the incoming data from the user form
        $product = $this->validate();

        // [ 2 ] if the action is insert || update then execute
        try {
            
            // [ 2-1 ] Process new images if any are selected
            if (!empty($this->new_images)) {
                foreach ($this->new_images as $image) {
                    // Store image file in the public storage directory under 'products'
                    $path = $image->store('products', 'public');
                    // Add the path string to our images array
                    $this->images[] = $path;
                }
            }

            // [ 2-2 ] Prepare compilation payload array to pass to the action layer
            $payload = [
                'name'        => $this->name,
                'category_id' => $this->category_id,
                'descripiton' => $this->descripiton,
                'is_visible'  => $this->is_visible,
                'images'      => $this->images, // Passes the full array to be saved as JSON
            ];

            // [ 2-3 ] Call the action to insert or update data
            $action->execute($payload, $this->product);

            // [ 2-4 ] Flash the success message
            session()->flash('status', $this->isEditMode ? 'Product updated.' : 'Product created.');

            // [ 2-5 ] Redirect to products main page
            return redirect()->route('panel.products');

        } catch(\Exception $ex) {
            
            // [ 2-1 ] Show error messages if not able to update record
            session()->flash('error', $ex);
            // session()->flash('error', 'Product '. $product['name'] .' data failed to update! because: ' . $ex);

        }
    }

    #[Title('Products Data Manager')]
    public function render()
    {
        return view('livewire.admin.products.upsert', [
            'categories' => Category::where('is_visible', 1)->get()
        ]);
    }
}
