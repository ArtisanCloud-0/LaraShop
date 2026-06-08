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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Protect historical financial ledger data by restricting order ledger removal
            $table->foreignId('order_ledger_id')->constrained()->restrictOnDelete();
            // Restrict on delete protects your accounting tracking if a variant is discontinued
            $table->foreignId('sku_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('price'); // Saved historical price snapshot at checkout
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
