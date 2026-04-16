<?php

use App\Enums\EthnicityEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEthnicityColumnInPeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peers', function (Blueprint $table) {
            $table->enum('ethnicity', EthnicityEnum::getValues())->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peers', function (Blueprint $table) {
            $table->string('ethnicity')->nullable()->change();
        });
    }
}
