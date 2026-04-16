<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRoleIdFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key and column roleId
            $table->dropForeign(['roleId']);
            $table->dropColumn('roleId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the roleId column with a foreign key constraint
            $table->unsignedBigInteger('roleId');
            $table->foreign('roleId')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
