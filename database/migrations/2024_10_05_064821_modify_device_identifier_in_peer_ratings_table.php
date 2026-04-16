<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDeviceIdentifierInPeerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peer_ratings', function (Blueprint $table) {
            $table->string('deviceIdentifier')->nullable();
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
            $table->dropColumn('deviceIdentifier');
        });
    }
}
