<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            // Clean up items automatically if the parent cart container is deleted
            $table->foreignUlid('cart_id')->constrained()->cascadeOnDelete();
            // Restrict on delete prevents a SKU from disappearing if active carts hold it
            $table->foreignId('sku_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            // Prevents multiple rows of the exact same variant in a single cart
            $table->unique(['cart_id', 'sku_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
