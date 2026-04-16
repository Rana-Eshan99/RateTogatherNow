<?php
namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use App\Mail\OtpMail;
use App\Enums\OtpStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialService
{
    /**
     * Handle the callback for social authentication.
     *
     * @param string $serviceProvider
     * @return array
     * @throws \Exception
     */
    public function handleCallback(string $serviceProvider)
    {
        try {
            DB::beginTransaction();

            // Fetch user data from the social provider
            $user = Socialite::driver($serviceProvider)->user();
            $email = $user->email;
            $providerId = $user->id;
            $firstName = $user->user['given_name'] ?? null;
            $lastName = $user->user['family_name'] ?? null;

            // Check if the email belongs to an admin
            $adminEmail = User::role('Admin')->where('email', $email)->first();
            if ($adminEmail) {
                throw new \ErrorException(__('messages.error.invalidAdminLogin'));
            }

            // Check if the user already exists
            $existUser = User::where('email', $email)->first();

            if ($existUser) {
                // If the user exists, validate the provider ID
                if ($serviceProvider === 'google' && $existUser->gmailId !== $providerId) {
                    throw new \ErrorException(__('messages.error.emailRegistered'));
                } elseif ($serviceProvider === 'apple' && $existUser->appleId !== $providerId) {
                    throw new \ErrorException(__('messages.error.emailRegistered'));
                }
            }

            // No OTP is generated for new users (signup), just proceed with user creation
            DB::commit();

            // Prepare the callback response data
            return $this->prepareCallbackData($serviceProvider, $email, $providerId, $existUser, $firstName, $lastName);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }


    /**
     * Prepare the data to return based on the service provider and user existence.
     *
     * @param string $serviceProvider
     * @param string $email
     * @param string $providerId
     * @param \App\Models\User|null $existUser
     * @return array
     */
    private function prepareCallbackData(string $serviceProvider, string $email, string $providerId, $existUser, $firstName, $lastName)
    {
        try {
            $statusPrefix = $serviceProvider === 'google' ? 'Google' : 'Apple';

            return [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'providerId' => $providerId,
                'status' => $existUser
                    ? "{$statusPrefix}SignInSuccess"
                    : "{$statusPrefix}SignUpSuccess"
            ];
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
