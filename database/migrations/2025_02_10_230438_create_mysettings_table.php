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
        Schema::create('mysettings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('app_logo');
            $table->string('app_favicon');
            $table->string('app_email');
            $table->string('app_phone');
            $table->string('app_country');
            $table->string('app_mobile_link');
            $table->string('current_currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mysettings');
    }
};
