<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\Otp;
use Illuminate\Contracts\Validation\Rule;

class ValidOtp implements Rule
{
    protected $errorMessage;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $email = request('email');
        $otpCode = Otp::where(['emailPhoneNumber' => $email, 'otp' => $value])->first();

        if (!$otpCode) {
            $this->errorMessage = __('messages.error.invalidOtpCode');
            return false;
        }
        else{

            $otpCreatedTime = Carbon::parse($otpCode->createdAt);
            $differenceInSeconds = $otpCreatedTime->diffInSeconds(Carbon::now('UTC'));

            if ($differenceInSeconds > 180) {
                $this->errorMessage = __('messages.error.expiredOtpCode');
                $otpCode->delete();
                return false;
            }
            else{
                return true;
            }
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
