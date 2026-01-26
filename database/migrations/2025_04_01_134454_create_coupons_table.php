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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // كود الكوبون
            $table->decimal('discount', 8, 2); // نسبة الخصم
            $table->string('valid_from'); // تاريخ بداية الكوبون
            $table->string('valid_to'); // تاريخ نهاية الكوبون
            $table->string('image')->nullable(); //
            $table->string('description')->nullable(); // وصف الكوبون
            $table->integer('usage_limit')->nullable(); // عدد مرات الاستخدام
            $table->string('status')->default(0);
            $table->integer('used')->default(0); // عدد مرات الاستخدام الفعلية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
