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
        Schema::create('items_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id'); // الصنف التابع له
            $table->string('name'); // مثلاً: صغير - وسط - كبير
            $table->decimal('price', 10, 2); // السعر لكل variation
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items-variations');
    }
};
