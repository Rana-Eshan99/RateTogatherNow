<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Organization and Department Id
            // Organization Id
            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations')->onDelete('set null');


            // Department Id
            $table->unsignedBigInteger('departmentId')->nullable();
            $table->foreign('departmentId')->references('id')->on('departments')->onDelete('set null');

            // Role Id
            $table->unsignedBigInteger('roleId');
            $table->foreign('roleId')->references('id')->on('roles')->onDelete('cascade');
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
            $table->dropForeign(['organizationId']);
            $table->dropColumn('organizationId');

            $table->dropForeign(['departmentId']);
            $table->dropColumn('departmentId');

            $table->dropForeign(['roleId']);
            $table->dropColumn('roleId');
        });
    }
}
