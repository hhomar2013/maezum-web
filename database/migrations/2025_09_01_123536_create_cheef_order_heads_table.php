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
        Schema::create('cheef_order_heads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->decimal('total', 8, 2);
            $table->string('status')->default('pending');
            $table->string('type')->nullable(); // Now or Late
            //if type is late
            $table->string('date_at')->nullable();
            $table->string('time_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade')->nullOnDelete();
            $table->string('address')->nullable();
            //if payment method is online payment
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheef_order_heads');
    }
};
