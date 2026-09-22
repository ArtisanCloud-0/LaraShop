<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\OrderLedger;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
         * -------------------------------------------------------------
         * 1. Admin and customers
         * -------------------------------------------------------------
         */

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@larashop.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'phone' => null,
            'image' => null,
        ]);

        // $customers = User::factory(10)->create([
        //     'role' => 'Customer',
        // ]);

        // /*
        //  * -------------------------------------------------------------
        //  * 2. Categories
        //  * -------------------------------------------------------------
        //  */

        // $parentCategory = Category::create([
        //     'name' => 'Clothes',
        //     'slug' => 'clothes',
        //     'parent_id' => null,
        // ]);

        // $subCategory = Category::create([
        //     'name' => 'T-Shirts',
        //     'slug' => 't-shirts',
        //     'parent_id' => $parentCategory->id,
        // ]);

        // /*
        //  * -------------------------------------------------------------
        //  * 3. Products and variants
        //  * -------------------------------------------------------------
        //  */

        // $allVariants = collect();

        // $colors = [
        //     'GREEN',
        //     'BLACK',
        //     'WHITE',
        //     'NAVY',
        // ];

        // $sizes = [
        //     'S',
        //     'M',
        //     'L',
        //     'XL',
        // ];

        // /*
        //  * Remote placeholder URLs for products and variants.
        //  */
        // $placeholderCovers = [
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+1',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+2',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+3',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+4',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+5',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+6',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+7',
        //     'https://placehold.co/800x800/png?text=LaraShop+Cover+8',
        // ];

        // $variantImages = [
        //     'https://placehold.co/800x800/png?text=Variant+Angle+1',
        //     'https://placehold.co/800x800/png?text=Variant+Angle+2',
        // ];

        // foreach (range(1, 8) as $i) {
        //     /*
        //      * Create parent product using `cover_image` instead of `images`.
        //      */
        //     $product = Product::create([
        //         'category_id' => $subCategory->id,
        //         'name' => "Custom T-Shirt #{$i}",
        //         'slug' => "custom-t-shirt-{$i}-" . Str::lower(Str::random(5)),
        //         'cover_image' => $placeholderCovers[$i - 1],
        //         'description' => "A demo product for LaraShop. This product is seeded for demonstration and portfolio purposes.",
        //         'is_visible' => true,
        //     ]);

        //     /*
        //      * Create 2-4 variants for each product.
        //      */
        //     $variantCount = rand(2, 4);
        //     $usedCodes = [];

        //     for ($v = 0; $v < $variantCount; $v++) {
        //         $color = $colors[array_rand($colors)];
        //         $size = $sizes[array_rand($sizes)];

        //         $code = "TSHIRT_{$i}_{$color}_{$size}_" . strtoupper(Str::random(4));

        //         if (
        //             in_array($code, $usedCodes, true) ||
        //             ProductDetails::withTrashed()->where('code', $code)->exists()
        //         ) {
        //             $v--;
        //             continue;
        //         }

        //         $usedCodes[] = $code;

        //         /*
        //          * Create variant SKU with its own images array.
        //          */
        //         $variant = ProductDetails::create([
        //             'product_id' => $product->id,
        //             'code' => $code,
        //             'price' => rand(25, 80) * 100,
        //             'stock' => rand(10, 50),
        //             'options' => [
        //                 'Color' => ucfirst(strtolower($color)),
        //                 'Size' => $size,
        //             ],
        //             'images' => [
        //                 $variantImages[0],
        //                 $variantImages[1],
        //             ],
        //         ]);

        //         $allVariants->push($variant);
        //     }
        // }

        // /*
        //  * -------------------------------------------------------------
        //  * 4. Sample orders
        //  * -------------------------------------------------------------
        //  */

        // foreach (range(1, 15) as $i) {
        //     $user = $customers->random();

        //     $order = OrderLedger::create([
        //         'order_number' => 'ORD-' . strtoupper(Str::random(8)),
        //         'user_id' => $user->id,
        //         'customer_name' => $user->name,
        //         'customer_email' => $user->email,
        //         'customer_phone' => null,
        //         'status' => OrderStatus::PENDING,
        //         'total_amount' => 0,
        //         'payment_gateway' => null,
        //     ]);

        //     $total = 0;

        //     $selectedVariants = $allVariants
        //         ->shuffle()
        //         ->take(rand(1, 3));

        //     foreach ($selectedVariants as $variant) {
        //         $quantity = rand(1, 3);

        //         $quantity = min(
        //             $quantity,
        //             $variant->stock
        //         );

        //         if ($quantity < 1) {
        //             continue;
        //         }

        //         /*
        //          * Access raw price integer if model mutator converts to float
        //          */
        //         $rawPrice = is_numeric($variant->getRawOriginal('price'))
        //             ? (int) $variant->getRawOriginal('price')
        //             : (int) round(((float) $variant->price) * 100);

        //         $subtotal = $rawPrice * $quantity;
        //         $total += $subtotal;

        //         OrderItem::create([
        //             'order_ledger_id' => $order->id,
        //             'product_details_id' => $variant->id,
        //             'price' => $rawPrice,
        //             'quantity' => $quantity,
        //         ]);
        //     }

        //     $order->update([
        //         'total_amount' => $total,
        //     ]);
        // }
    }
}
