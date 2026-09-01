<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->enum('order_type', ['pickup', 'delivery'])->default('delivery');
            $table->string('delivery_address')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('delivery_fee', 8, 2)->default(0.00);
            $table->decimal('total', 8, 2);
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_name');
            $table->decimal('unit_price', 8, 2);
            $table->integer('quantity');
            $table->json('selected_options')->nullable(); // e.g. {"fries": "Gajo", "sauce": "Jack Daniel's"}
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
