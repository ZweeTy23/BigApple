<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable();
            $table->string('badge')->nullable(); // e.g. "Popular", "Insignia", "Nuevo"
            $table->enum('type', ['standard', 'burger', 'chicken_sandwich', 'fettuccine', 'pasta_wizard', 'crepa_wizard', 'portion_selectable'])->default('standard');
            $table->boolean('is_available')->default(true);
            $table->json('variants')->nullable(); // For size options like 9 Pzas ($109) / 14 Pzas ($139) or Individual/Pareja
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
