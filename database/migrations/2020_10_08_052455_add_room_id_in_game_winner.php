<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomIdInGameWinner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_winner', function (Blueprint $table) {
            if (!Schema::hasColumn('game_winner', 'room_id')) {
                $table->integer('room_id')->after('tournament_id')->comment("play_game PK")->default(null);
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
            $table->dropColumn('room_id');
        });
    }
}
