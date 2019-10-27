<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBridgeDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bridge_device', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bridge_id')->unsigned();
            $table->integer('device_id')->unsigned();
            $table->timestamps();

            $table->foreign('bridge_id')->references('id')->on('bridges')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bridge_device');
    }
}
