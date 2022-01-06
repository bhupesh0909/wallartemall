<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayGamesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_games', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('game_type', ['fun', 'cash', 'tournament'])->default('cash');
            $table->integer('game_id');
            $table->integer('user_id');
            $table->integer('total_players');
            $table->integer('entry_fee');
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
        Schema::drop('play_games');
    }
}
