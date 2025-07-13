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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->onDelete('cascade');

            $table->enum('type', ['restock', 'use', 'adjustment']);
            $table->integer('quantity');
            $table->text('note')->nullable();
            $table->timestamp('transaction_date')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
