<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChipsTypeInChipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chips', function (Blueprint $table) {
            if (!Schema::hasColumn('chips', 'chips_type')) {
                // $table->string('chips_type')->after('chips_amount')->comment("WR: Welcome Reward")->default(null);
                $table->enum('chips_type', ['WR', 'RR', 'AR'])->after('chips_amount')->comment("WR: Welcome Reward, RR: Refer Reward, AR: Admin Reward")->nullable()->default(null);
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
        Schema::table('chips', function (Blueprint $table) {
            $table->dropColumn('chips_type');
        });
    }
}
