<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_user_locations', function (Blueprint $table) {
            $table->id();
            $table->string('deviceIdentifier');
            $table->decimal('latitude',11,7);
            $table->decimal('longitude',11,7);

            $table->unsignedInteger('createdAt');
            $table->unsignedInteger('updatedAt');
            $table->unsignedBigInteger('deletedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_user_locations');
    }
}
