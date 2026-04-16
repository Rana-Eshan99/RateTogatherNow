<?php

use App\Enums\OrganizationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peer_ratings', function (Blueprint $table) {
            $table->id();

            ////  User Organization Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations');
            //// User Organization Id

            $table->integer('easyWork');
            $table->boolean('workAgain');
            $table->integer('dependableWork');
            $table->integer('meetDeadline');
            $table->integer('receivingFeedback');

            $table->integer('respectfullOther');
            $table->boolean('assistOther');
            $table->boolean('collaborateTeam');

            $table->text('experience');

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
        Schema::dropIfExists('peer_ratings');
    }
}
