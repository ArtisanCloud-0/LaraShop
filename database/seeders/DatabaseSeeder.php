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

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@larashop.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $customers = User::factory(10)->create([
            'role' => 'Customer',
        ]);

        /*
         * -------------------------------------------------------------
         * 2. Categories
         * -------------------------------------------------------------
         */

        $parentCategory = Category::create([
            'name' => 'Clothes',
            'slug' => 'clothes',
            'parent_id' => null,
        ]);

        $subCategory = Category::create([
            'name' => 'T-Shirts',
            'slug' => 't-shirts',
            'parent_id' => $parentCategory->id,
        ]);

        /*
         * -------------------------------------------------------------
         * 3. Products and variants
         * -------------------------------------------------------------
         */

        $allVariants = collect();

        $colors = [
            'GREEN',
            'BLACK',
            'WHITE',
            'NAVY',
        ];

        $sizes = [
            'S',
            'M',
            'L',
            'XL',
        ];

        /*
         * Placeholder images.
         *
         * These are remote placeholder URLs, so the seeded products
         * immediately have something useful to display in the product
         * cards without requiring uploaded image files.
         *
         * The Product model already casts "images" to an array and
         * exposes the first image as "primary_image".
         */
        $placeholderImages = [
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+1',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+2',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+3',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+4',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+5',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+6',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+7',
            'https://placehold.co/800x800/png?text=LaraShop+T-Shirt+8',
        ];

        foreach (range(1, 8) as $i) {
            /*
             * Create the parent product.
             */
            $product = Product::create([
                'category_id' => $subCategory->id,

                'name' => "Custom T-Shirt #{$i}",

                'slug' => "custom-t-shirt-{$i}-"
                    . Str::lower(Str::random(5)),

                /*
                 * Product images are stored as an array because the
                 * Product model casts this field to an array.
                 */
                'images' => [
                    $placeholderImages[$i - 1],
                ],

                'description' => "A demo product for LaraShop. "
                    . "This product is seeded for demonstration "
                    . "and portfolio purposes.",

                'is_visible' => true,
            ]);

            /*
             * Create 2-4 variants for each product.
             */
            $variantCount = rand(2, 4);

            $usedCodes = [];

            for ($v = 0; $v < $variantCount; $v++) {
                $color = $colors[array_rand($colors)];
                $size = $sizes[array_rand($sizes)];

                $code = "TSHIRT_{$i}_{$color}_{$size}_"
                    . strtoupper(Str::random(4));

                /*
                 * Avoid duplicate variant codes.
                 */
                if (
                    in_array($code, $usedCodes, true) ||
                    ProductDetails::withTrashed()
                    ->where('code', $code)
                    ->exists()
                ) {
                    $v--;
                    continue;
                }

                $usedCodes[] = $code;

                $variant = ProductDetails::create([
                    'product_id' => $product->id,

                    'code' => $code,

                    /*
                     * Money is stored in cents.
                     */
                    'price' => rand(25, 80) * 100,

                    'stock' => rand(10, 50),

                    'options' => [
                        'Color' => ucfirst(strtolower($color)),
                        'Size' => $size,
                    ],
                ]);

                $allVariants->push($variant);
            }
        }

        /*
         * -------------------------------------------------------------
         * 4. Sample orders
         * -------------------------------------------------------------
         */

        foreach (range(1, 15) as $i) {
            $user = $customers->random();

            /*
             * Customer information is copied into the order as a
             * historical snapshot.
             */
            $order = OrderLedger::create([
                'order_number' => 'ORD-'
                    . strtoupper(Str::random(8)),

                'user_id' => $user->id,

                'customer_name' => $user->name,

                'customer_email' => $user->email,

                /*
                 * User factory may not provide a phone number,
                 * therefore this remains nullable in the order.
                 */
                'customer_phone' => null,

                /*
                 * Seeded orders are not actually paid through a
                 * payment gateway.
                 */
                'status' => OrderStatus::PENDING,

                'total_amount' => 0,

                'payment_gateway' => null,
            ]);

            $total = 0;

            /*
             * Select 1-3 different variants.
             */
            $selectedVariants = $allVariants
                ->shuffle()
                ->take(rand(1, 3));

            foreach ($selectedVariants as $variant) {
                $quantity = rand(1, 3);

                /*
                 * Make sure the seeded order doesn't claim more
                 * inventory than exists.
                 */
                $quantity = min(
                    $quantity,
                    $variant->stock
                );

                if ($quantity < 1) {
                    continue;
                }

                $subtotal = $variant->price * $quantity;

                $total += $subtotal;

                /*
                 * This matches the actual order_items migration:
                 *
                 * order_ledger_id
                 * product_details_id
                 * price
                 * quantity
                 */
                OrderItem::create([
                    'order_ledger_id' => $order->id,

                    'product_details_id' => $variant->id,

                    /*
                     * Historical unit price snapshot.
                     */
                    'price' => $variant->price,

                    'quantity' => $quantity,
                ]);
            }

            /*
             * Update the final order total after creating the items.
             */
            $order->update([
                'total_amount' => $total,
            ]);
        }
    }
}
