<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('configName');
            $table->string('name');
            $table->string('value')->nullable(); 
            $table->string('comment')->nullable(); 
            $table->enum('type', ['ConfigBoolean', 'ConfigString','ConfigNumber']);
            $table->enum('serverType', ['staging', 'acceptance','production','local']);
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
        Schema::dropIfExists('configurations');
    }
}
