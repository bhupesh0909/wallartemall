<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetAccountInfoProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP procedure IF EXISTS Get_Account_Info");
        $procedure = "CREATE PROCEDURE `Get_Account_Info`(IN `user_id` INT) NO SQL
                        BEGIN
                            SET @matches_played:=0;
                            SELECT
                                `id`,
                                `total_amount`,
                                `total_played`,
                                `winner`,
                                `redeem`,
                                `pending_bonus`,
                                `inplay_cash`,
                                `profile_pic`,
                                @matches_played:= total_played as `total_played`,
                                IFNULL((SELECT level FROM player_ranking WHERE @matches_played >= matches ORDER BY matches DESC LIMIT 1), NULL) as `level`,
                                IFNULL((SELECT icon FROM player_ranking WHERE @matches_played >= matches ORDER BY matches DESC LIMIT 1), NULL) as `icon`
                            FROM
                                `users`
                            WHERE
                                `id` = user_id AND `users`.`deleted_at` IS NULL;
                        END";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP procedure IF EXISTS Get_Account_Info");
    }
}
