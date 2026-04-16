<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysInHelpfulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helpful', function (Blueprint $table) {
            // Drop the foreign key if it already exists
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('peers', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('organization_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('peer_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('application_feedback', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('saveds', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('report_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helpful', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('peers', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('organization_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('peer_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('application_feedback', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('saveds', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        Schema::table('report_ratings', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });
    }
}
