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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 10)->unique(); // USD, EUR, JPY, GBP
            $table->string('currency_name', 50); // Tên đầy đủ
            $table->decimal('buy_rate', 15, 2)->nullable(); // Tỷ giá mua
            $table->decimal('sell_rate', 15, 2)->nullable(); // Tỷ giá bán
            $table->decimal('transfer_rate', 15, 2)->nullable(); // Tỷ giá chuyển khoản
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
