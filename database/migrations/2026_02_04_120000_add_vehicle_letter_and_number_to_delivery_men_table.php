<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehicleLetterAndNumberToDeliveryMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->string('vehicle_letter')->after('vehicle_id');
            $table->string('vehicle_number')->after('vehicle_letter');
            $table->string('vehicle_color')->after('vehicle_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropColumn(['vehicle_letter', 'vehicle_number', 'vehicle_color']);
        });
    }
}
