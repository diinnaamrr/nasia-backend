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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['customer', 'trader'])->default('customer')->after('id');
            $table->string('trader_image')->nullable()->after('image');
            $table->string('card_back')->nullable()->after('trader_image');
            $table->string('card_face')->nullable()->after('card_back');
            $table->boolean('is_trader_approved')->default(false)->after('card_face');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'trader_image', 'card_back', 'card_face', 'is_trader_approved']);
        });
    }
};
