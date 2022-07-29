<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location_season extends Model
{
    public function up()
    {
        Schema::create('location_season', function (Blueprint $table) {
            //student_idとsubject_idを外部キーに設定
            $table->integer('location_id')->unsigned();    //students,subjectsテーブルのidが
            $table->integer('season_id')->unsigned();    //bigIncrementであった場合はbigIntegerにする
            $table->primary(['location_id', 'season_id']);  
        });
    }
}
