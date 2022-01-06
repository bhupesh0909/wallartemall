<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddtournamentIdInPlayGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('play_games', function (Blueprint $table) {
            if(!Schema::hasColumn('play_games', 'tournament_id')){
                $table->integer('tournament_id')->nullable()->after('game_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('play_games', function (Blueprint $table) {
            $table->dropColumn('tournament_id');
        });
    }
}
