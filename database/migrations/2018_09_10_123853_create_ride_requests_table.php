<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRideRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requester_id');
            $table->unsignedInteger('ride_id');
            $table->unsignedInteger('enroute_city_id')->nullable();
            $table->enum('status', ['approved', 'submitted', 'rejected'])->default('submitted');
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
        Schema::dropIfExists('rides_requests');
    }
}
