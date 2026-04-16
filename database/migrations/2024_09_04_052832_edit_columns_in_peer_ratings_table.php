<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsInPeerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peer_ratings', function (Blueprint $table) {
            // Add New Columns);
            // Add communicateUnderPressure column after dependableWork
            $table->integer('communicateUnderPressure')->after('dependableWork');

            // Modify existing columns
            $table->integer('assistOther')->change();
            $table->integer('collaborateTeam')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peer_ratings', function (Blueprint $table) {
            // Drop communicateUnderPressure column
            $table->dropColumn('communicateUnderPressure');

            // Revert changes to existing columns
            $table->boolean('assistOther')->change();
            $table->boolean('collaborateTeam')->change();
        });
    }
}
