<?php

use App\Enums\OtpStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('emailPhoneNumber');
            $table->string('otp');

            $table->enum('otpType', OtpStatusEnum::getValues());

            $table->boolean('isVerified')->default(0);

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
        Schema::dropIfExists('otps');
    }
}
