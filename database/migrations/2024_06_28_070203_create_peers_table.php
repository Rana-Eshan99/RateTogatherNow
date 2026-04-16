<?php

use App\Enums\GenderEnum;
use App\Enums\EthnicityEnum;
use App\Enums\PeerStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peers', function (Blueprint $table) {
            $table->id();

            ////  User Organization Department Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations');

            $table->unsignedBigInteger('departmentId')->nullable();
            $table->foreign('departmentId')->references('id')->on('departments');
            //// User Organization Department Id

            $table->string('firstName');
            $table->string('lastName');

            $table->enum('gender', GenderEnum::getValues())->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('jobTitle');
            $table->string('image');
            $table->enum('status', PeerStatusEnum::getValues());

            $table->unsignedInteger('createdAt');
            $table->unsignedInteger('updatedAt');
            $table->unsignedInteger('deletedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peers');
    }
}
