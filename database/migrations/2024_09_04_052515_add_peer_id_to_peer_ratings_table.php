<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeerIdToPeerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peer_ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('peerId')->nullable()->after('id');
            $table->foreign('peerId')->references('id')->on('peers');
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
            $table->dropForeign(['peerId']);
            $table->dropColumn('peerId');
        });
    }
}
