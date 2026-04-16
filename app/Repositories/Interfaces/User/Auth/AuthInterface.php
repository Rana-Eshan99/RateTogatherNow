<?php

namespace App\Repositories\Interfaces\User\Auth;

interface AuthInterface
{

    /**
     * Send otp
     */
    public function sendOtp($data, $otpType);

    /**
     * Verify otp
     */
    public function verifyOtp($data, $otpType);

    /**
     * Attempt LogIn
     */
    public function attemptLogIn($data);

    /**
     * Create user
     */
    public function createUser(array $data);
}
