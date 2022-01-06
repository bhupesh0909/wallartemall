<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerInGameTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_tournaments', function (Blueprint $table) {
            if (!Schema::hasColumn('game_tournaments', 'banner')) {
                $table->string('banner')->after('t_format')->nullable()->default(null);
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
        Schema::table('game_tournaments', function (Blueprint $table) {
            if (Schema::hasColumn('game_tournaments', 'banner')) {
                $table->dropColumn('banner');
            }
        });
    }
}
