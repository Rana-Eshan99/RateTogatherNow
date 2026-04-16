<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\PasswordResetResponse as PasswordResetResponseContract;

class PasswordResetResponse implements PasswordResetResponseContract
{
    public function toResponse($request)
    {
        // Redirect to the 'adminSignInForm' route after password reset
        return redirect()->route('adminSignInForm')->with('status', trans('passwords.reset'));
    }
}
