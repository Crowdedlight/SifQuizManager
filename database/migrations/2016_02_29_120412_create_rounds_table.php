<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('numTeams');
            $table->boolean('active')->default(false);
            $table->string('status');
            $table->timestamps();
            $table->integer('FK_userID')->unsigned();
        });

        Schema::table('rounds', function ($table) {
            $table->foreign('FK_userID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rounds');
    }
}
