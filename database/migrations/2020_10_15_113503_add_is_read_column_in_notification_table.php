<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsReadColumnInNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification', function (Blueprint $table) {
            if (!Schema::hasColumn('notification', 'is_read')) {
                $table->enum('is_read', [null,1])->after('notification_desc')->comment('null or 0:false, 1:true')->nullable()->default(null);
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
        Schema::table('notification', function (Blueprint $table) {
            if (Schema::hasColumn('notification', 'is_read')) {
                $table->dropColumn('is_read');
            }
        });
    }
}
