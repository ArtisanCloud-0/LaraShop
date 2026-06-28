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
            $table->id();
            // Cascade on delete means if the core product is wiped, its variants go with it
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique(); // e.g., TSHIRT-RED-XL
            $table->unsignedInteger('price'); // Stored in cents (integer format)
            $table->integer('stock')->default(0);
            $table->json('options')->nullable(); // For dynamic variants e.g. {"size": "XL"}
            $table->timestamps();
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
