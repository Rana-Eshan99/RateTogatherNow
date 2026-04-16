<?php

use App\Enums\FeedbackStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_feedback', function (Blueprint $table) {
            $table->id();

            ////  User Id
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');
            //// User Id
            $table->string('feeling');
            $table->text('feedback');
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
        Schema::dropIfExists('application_feedback');
    }
}