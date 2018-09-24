<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('time');
            $table->unsignedInteger('car_user_id');
            $table->unsignedInteger('source_city_id');
            $table->unsignedInteger('destination_city_id');
            $table->unsignedInteger('seats_offered');
            $table->unsignedInteger('price_per_seat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rides');
    }
}
