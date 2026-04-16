<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDeviceIdentifierInApplicationFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_feedback', function (Blueprint $table) {
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
        Schema::table('application_feedback', function (Blueprint $table) {
            $table->dropColumn('deviceIdentifier');
        });
    }
}
