<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['countryId']);
            $table->dropColumn('countryId');

            $table->dropForeign(['stateId']);
            $table->dropColumn('stateId');

            // Add new columns with updated types
            $table->string('country');
            $table->string('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
              // Remove the new columns
              $table->dropColumn('country');
              $table->dropColumn('state');

              // Re-add the old columns with foreign key constraints
              $table->unsignedBigInteger('countryId')->nullable();
              $table->foreign('countryId')->references('id')->on('countries');

              $table->unsignedBigInteger('stateId')->nullable();
              $table->foreign('stateId')->references('id')->on('states');
        });
    }
}
