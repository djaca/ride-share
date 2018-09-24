<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrouteCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enroute_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ride_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('order_from_source');
            $table->unsignedInteger('prorated_price');
            $table->timestamps();

            $table->unique(['ride_id', 'order_from_source']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enroute_cities');
    }
}
