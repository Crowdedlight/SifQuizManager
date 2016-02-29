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
            $table->integer('FK_round')->unsigned();
            $table->integer('FK_team')->unsigned();
            $table->timestamps();
            $table->integer('position');
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
