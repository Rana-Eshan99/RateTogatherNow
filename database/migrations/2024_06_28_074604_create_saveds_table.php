<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saveds', function (Blueprint $table) {
            $table->id();

            ////  User Organization Peer Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');

            $table->unsignedBigInteger('organizationId')->nullable();
            $table->foreign('organizationId')->references('id')->on('organizations');

            $table->unsignedBigInteger('peerId')->nullable();
            $table->foreign('peerId')->references('id')->on('peers');
            //// User Organization Peer Id

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
        Schema::dropIfExists('saveds');
    }
}
