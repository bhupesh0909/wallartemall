<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTournamentIdInGameWinner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_winner', function (Blueprint $table) {
            if(!Schema::hasColumn('game_winner', 'tournament_id')){
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
        Schema::table('game_winner', function (Blueprint $table) {
            $table->dropColumn('tournament_id');
        });
    }
}
