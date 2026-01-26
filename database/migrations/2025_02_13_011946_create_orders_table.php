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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // لو عندك نظام مستخدمين
            $table->decimal('total_price', 8, 2);
            $table->string('status')->default('pending'); // الحالة الافتراضية
            $table->text('shipping_address')->nullable(); // عنوان الشحن// عنوان الفوترة
            $table->string('payment_method')->nullable(); // طريقة الدفع
            $table->string('tracking_number')->nullable(); // رقم التتبع
            $table->timestamp('shipped_at')->nullable(); // وقت الشحن
            $table->timestamp('delivered_at')->nullable(); // وقت التسليم
            $table->timestamp('canceled_at')->nullable(); // وقت الإلغاء
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->string('coupon_code')->nullable(); // كود الخصم
            $table->decimal('discount_amount', 8, 2)->default(0.00); // مبلغ الخصم// مبلغ الضريبة
            $table->decimal('shipping_cost', 8, 2)->default(0.00); // تكلفة الشحن
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
