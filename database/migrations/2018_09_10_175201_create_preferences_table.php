<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->boolean('dialog_allowed')->default(true);
            $table->boolean('music_allowed')->default(true);
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('pet_allowed')->default(false);
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
        Schema::dropIfExists('preferences');
    }
}
