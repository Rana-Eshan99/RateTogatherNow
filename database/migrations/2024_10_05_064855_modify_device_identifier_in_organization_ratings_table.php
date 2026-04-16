<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDeviceIdentifierInOrganizationRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_ratings', function (Blueprint $table) {
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
        Schema::table('organization_ratings', function (Blueprint $table) {
            $table->dropColumn('deviceIdentifier');
        });
    }
}
