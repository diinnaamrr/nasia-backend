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
        Schema::create('addon_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key_name');
            $table->text('live_values')->nullable();
            $table->text('test_values')->nullable();
            $table->string('settings_type');
            $table->string('mode')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addon_settings');
    }
};
