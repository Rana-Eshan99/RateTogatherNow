<?php

use App\Enums\OrganizationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();

            ////  User Country State Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            $table->unsignedBigInteger('countryId')->nullable();
            $table->foreign('countryId')->references('id')->on('countries');

            $table->unsignedBigInteger('stateId')->nullable();
            $table->foreign('stateId')->references('id')->on('states');
            //// User Country State Id

            $table->string('name');
            $table->string('image');
            $table->string('city');

            $table->string('address');

            $table->enum('status', OrganizationStatusEnum::getValues());

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
        Schema::dropIfExists('organizations');
    }
}
