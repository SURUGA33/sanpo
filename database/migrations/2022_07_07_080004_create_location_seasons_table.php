<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_seasons', function (Blueprint $table) {
            $table->integer('location_id')->unsigned();    //students,subjectsテーブルのidが
            $table->integer('season_id')->unsigned();    //bigIncrementであった場合はbigIntegerにする
            $table->primary(['location_id', 'season_id']);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_seasons');
    }
}
