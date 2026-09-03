<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Product name
            $table->string('slug')->unique(); // For SEO-friendly URLs
            $table->foreignId('category_id')->constrained()->restrictOnDelete(); // Restrict deletion if products exist in this category
            $table->text('description')->nullable(); // Optional product description
            $table->boolean('is_visible')->default(true); // Visibility toggle for the product
            $table->string('cover_image')->nullable(); // Optional cover image for the product
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
