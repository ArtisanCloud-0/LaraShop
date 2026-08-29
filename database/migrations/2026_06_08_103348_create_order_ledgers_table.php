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
        Schema::create('order_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Unique order number for tracking
            $table->foreignId('user_id')->nullable()->constrained()->restrictOnDelete(); // Optional user association, restrict deletion if user exists
            $table->string('customer_name'); // Customer's name for order identification
            $table->string('customer_email'); // Customer's email for communication and order confirmation
            $table->string('customer_phone')->nullable(); // Optional customer phone number for contact
            $table->unsignedInteger('total_amount'); // Total amount in cents to avoid floating point issues    
            $table->string('status'); // Order status (e.g., pending, paid, shipped) to track the order's lifecycle
            $table->string('payment_gateway')->nullable(); // Optional payment gateway used for the transaction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ledgers');
    }
};
