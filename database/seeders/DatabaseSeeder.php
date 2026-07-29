<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\ProductDetails;
use App\Models\OrderLedger As Order;

use App\Enums\OrderStatus;

use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

// 1. Create Admins and Customers
        $admin = User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@larashop.com',
            'role'  => 'Admin',
            'password' => Hash::make('password')
        ]);

        $customers = User::factory(10)->create(['role' => 'Customer']);

        // 2. Create Categories
        $parentCategory = Category::create([
            'name'      => 'Clothes',
            'slug'      => 'clothes_90XC&',
            'parent_id' => null,
        ]);

        $subCategory = Category::create([
            'name'      => 'T-shirt',
            'slug'      => 't-shirt_iou89#h',
            'parent_id' => $parentCategory->id,
        ]);

        // 3. Create Products and ProductDetailss (Variants)
        $allVariants = collect();
        $colors = ['GREEN', 'BLACK', 'WHITE', 'NAVY'];
        $sizes  = ['S', 'M', 'L', 'XL'];

        foreach (range(1, 8) as $i) {
            // Create Parent Product
            $product = Product::create([
                'category_id' => $subCategory->id,
                'name'        => "Custom T-Shirt #{$i}",
                'slug'        => "custom-t-shirt-{$i}",
            ]);

            // Create 2 to 4 variants in product_details for this product
            $variantCount = rand(2, 4);
            
            for ($v = 0; $v < $variantCount; $v++) {
                $color = $colors[array_rand($colors)];
                $size  = $sizes[array_rand($sizes)];
                $code  = "TSHIRT_{$i}_{$color}_{$size}";

                // Prevent duplicate codes if random picker selects the same combination
                if (ProductDetails::where('code', $code)->exists()) {
                    continue;
                }

                $variant = ProductDetails::create([
                    'product_id' => $product->id,
                    'code'       => $code,
                    'price'      => rand(25, 80),
                    'stock'      => rand(2, 50),
                    'options'     => [
                        'Color' => ucfirst(strtolower($color)),
                        'Size'  => $size,
                    ],
                ]);

                $allVariants->push($variant);
            }
        }

        // 4. Create Sample Orders linking to specific product variants
        foreach (range(1, 15) as $i) {
            $user = $customers->random();
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'      => $user->id,
                'status'       => OrderStatus::cases()[array_rand(OrderStatus::cases())],
                'total_amount' => 0,
            ]);

            $total = 0;
            
            // Pick 1-3 random variants from product_details
            foreach ($allVariants->random(rand(1, 3)) as $variant) {
                $qty = rand(1, 3);
                $subtotal = $variant->price * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_ledger_id'    => $order->id,
                    'product_details_id' => $variant->id,
                    'quantity'           => $qty,
                    'price'              => $variant->price,
                ]);
            }

            $order->update(['total_amount' => $total]);
        }

    }
}
