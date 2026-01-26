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
        Schema::create('market_items_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_items_id');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->foreign('market_items_id')->references('id')->on('market_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_items_variations');
    }
};
