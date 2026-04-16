<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdInHelpfulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helpful', function (Blueprint $table) {
           // Modify the userId to be nullable
           $table->unsignedBigInteger('userId')->nullable()->change();
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
        Schema::table('helpful', function (Blueprint $table) {
             // Revert the userId back to not nullable
             $table->unsignedBigInteger('userId')->nullable(false)->change();
             $table->dropColumn('deviceIdentifier');
        });
    }
}
