<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundteamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roundteams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('FK_round')->unsigned();
            $table->integer('FK_team')->unsigned();
            $table->timestamps();
            $table->integer('numPersons')->length(3)->unsigned();
            $table->integer('position');
            $table->double('points');

        });

        Schema::table('roundteams', function ($table) {
            $table->foreign('FK_round')->references('id')->on('rounds');
            $table->foreign('FK_team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roundteams');
    }
}
