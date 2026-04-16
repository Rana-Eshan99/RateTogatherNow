<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpfulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpful', function (Blueprint $table) {
            $table->id();

            //  UserId
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            //  organizationId
            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations');

            //  peerId
            $table->unsignedBigInteger('peerId')->nullable();
            $table->foreign('peerId')->references('id')->on('peers');

            //  organizationRatingId
            $table->unsignedBigInteger('organizationRatingId')->nullable();
            $table->foreign('organizationRatingId')->references('id')->on('organization_ratings');

            //  peerRatingId
            $table->unsignedBigInteger('peerRatingId')->nullable();
            $table->foreign('peerRatingId')->references('id')->on('peer_ratings');

            $table->boolean('isFoundHelpful');

            $table->unsignedInteger('createdAt');
            $table->unsignedInteger('updatedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpful');
    }
}
