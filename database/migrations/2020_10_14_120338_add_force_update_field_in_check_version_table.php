<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForceUpdateFieldInCheckVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('version', function (Blueprint $table) {
            if (!Schema::hasColumn('version', 'force_update')) {
                $table->enum('force_update', [0,1])->after('version')->comment('0:false, 1:true');
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
        Schema::table('version', function (Blueprint $table) {
            if (Schema::hasColumn('version', 'force_update')) {
                $table->dropColumn('force_update');
            }
        });
    }
}
