<?php

use App\Enums\FeedbackStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeedbackStatusIntoApplicationFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_feedback', function (Blueprint $table) {

            $table->enum('status', FeedbackStatusEnum::getValues())->after('userId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_feedback', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}