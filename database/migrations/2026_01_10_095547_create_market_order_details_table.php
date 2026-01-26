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
        Schema::create('market_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_header_id')->constrained('market_order_headers')->onDelete('cascade');
            $table->integer('product_id');
            $table->string('product_name_ar');
            $table->foreignId('market_item_variation_id')->nullable()->constrained('market_item_variations')->onDelete('set null');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('sub_total', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_order_details');
    }
};
