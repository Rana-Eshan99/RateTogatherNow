<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errorLogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filePath')->nullable();
            $table->integer('lineNo')->nullable();
            $table->string('statusCode')->nullable();
            $table->longText('errorMessage')->nullable();
            $table->enum('ticketStatus',['Pending','Resolved','Other'])->default('Pending');
            $table->text('developerComment')->nullable();
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
        Schema::dropIfExists('errorLogs');
    }
}
