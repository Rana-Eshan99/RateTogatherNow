<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SIGNIN_EMAIL_OTP()
 * @method static static SIGNUP_EMAIL_OTP()
 */
final class OtpStatusEnum extends Enum
{
    const SIGNIN_EMAIL_OTP =   'SIGNIN_EMAIL_OTP';
    const SIGNUP_EMAIL_OTP =   'SIGNUP_EMAIL_OTP';
}
