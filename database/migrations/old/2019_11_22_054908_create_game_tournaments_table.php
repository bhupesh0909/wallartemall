<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameTournamentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('t_type');
            $table->string('t_id');
            $table->string('t_format');
            $table->date('start_date');
            $table->string('entry');
            $table->string('starting_stack');
            $table->string('prize');
            $table->string('level');
            $table->string('no_of_prizes');
            $table->integer('r_user');
            $table->string('cash_prize');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_tournaments');
    }
}
