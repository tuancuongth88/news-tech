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
        Schema::create('gold_rates', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50); // SJC, 9999, 24K, etc.
            $table->string('location', 50)->nullable(); // Hà Nội, TP.HCM, etc.
            $table->decimal('buy_rate', 15, 2)->nullable(); // Giá mua
            $table->decimal('sell_rate', 15, 2)->nullable(); // Giá bán
            $table->string('unit', 20)->default('lượng'); // lượng, chỉ, gram
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_rates');
    }
};
