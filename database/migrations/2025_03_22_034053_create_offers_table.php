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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم العرض
            $table->text('description')->nullable(); // وصف العرض
            $table->decimal('discount', 8, 2); // نسبة الخصم
            $table->string('start_date'); // تاريخ بداية العرض
            $table->string('end_date'); // تاريخ نهاية العرض
            $table->boolean('status')->default(0); // حالة العرض
            $table->string('image')->nullable(); // صورة العرض
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
