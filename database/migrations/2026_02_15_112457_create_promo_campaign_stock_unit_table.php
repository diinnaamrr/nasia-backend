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
        Schema::create('promo_campaign_stock_unit', function (Blueprint $table) {
    $table->id();

    $table->foreignId('promo_campaign_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('stock_unit_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->decimal('discount_rate', 5, 2);

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_campaign_stock_unit');
    }
};
