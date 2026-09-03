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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // Foreign key referencing products table
            $table->string('code')->unique(); // Unique code for the product detail
            $table->unsignedInteger('price'); // Price of the product detail
            $table->integer('stock')->default(0); // Stock quantity for the product detail
            $table->json('options')->nullable(); // Optional JSON field for product options
            $table->json('images')->nullable(); // Optional JSON field for product images
            $table->softDeletes(); // Soft delete functionality
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
