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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Ingredient name
            $table->string('category');                // Category e.g., Protein, Vegetables
            $table->string('unit');                    // e.g., kg, pcs, L
            $table->integer('quantity')->default(0);  // Current stock quantity
            $table->integer('reorder_level')->default(10); // Minimum threshold to reorder
            $table->decimal('unit_price', 10, 2);      // Price per unit
            $table->string('supplier')->nullable();    // Optional supplier name
            $table->timestamps();                      // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
