<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input)
    {
        $input['password'] = trim($input['password']);
        $input['password_confirmation'] = trim($input['password_confirmation']);
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        if (Hash::check($input['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('You have recently used this password. Please choose a different password.'),
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
