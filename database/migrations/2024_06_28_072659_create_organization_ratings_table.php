<?php

use App\Enums\OrganizationRatingStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_ratings', function (Blueprint $table) {
            $table->id();

            ////  User Organization Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations');
            //// User Organization Id

            $table->integer('employeeHappyness');
            $table->integer('companyCulture');
            $table->integer('careerDevelopment');
            $table->integer('workLifeBalance');
            $table->integer('compensationBenefit');

            $table->integer('jobStability');
            $table->integer('workplaceDEI');
            $table->integer('companyReputation');
            $table->integer('workplaceSS');
            $table->integer('growthFuturePlan');

            $table->text('experience');

            $table->enum('status', OrganizationRatingStatusEnum::getValues());
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
        Schema::dropIfExists('organization_ratings');
    }
}
