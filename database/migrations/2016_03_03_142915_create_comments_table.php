<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('FK_round')->unsigned();
            $table->text('comment');
            $table->text('type');
            $table->integer('FK_user')->unsigned();
        });
        Schema::table('comments', function ($table) {
            $table->foreign('FK_round')->references('id')->on('rounds');
            $table->foreign('FK_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
