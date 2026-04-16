<?php

namespace App\Repositories\Repositories\User\Auth;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\Peer;
use App\Models\User;
use App\Mail\OtpMail;
use App\Enums\ServerEnum;
use App\Models\Department;
use App\Enums\OtpStatusEnum;
use App\Models\Organization;
use App\Enums\PeerStatusEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Enums\OrganizationStatusEnum;
use App\Repositories\Interfaces\User\Auth\AuthInterface;
use App\Traits\FileUploadTrait;

class AuthRepository implements AuthInterface
{
    use FileUploadTrait;

    /**
     * Send otp for SignIn / signUp
     */
    public function sendOtp($data, $otpType)
    {
        try {
            if (!in_array($otpType, ['signIn', 'signUp'])) {
                throw new \ErrorException(__('messages.error.invalidOtpType'));
            }

            $user = User::where('email', $data['email'])->first();

            // Check if Admin attempts login on the user panel than throw exception.
            if (($user) && ($user->hasRole('Admin'))) {
                throw new \ErrorException(__('messages.error.invalidAdminLogin'));
            }

            if (($otpType == 'signIn' && !($user))) {
                throw new \ErrorException(__('messages.error.emailNotRegistered'));
            } else if (($otpType == 'signIn' && $user->status == UserStatusEnum::BLOCK)) {
                throw new \ErrorException("Your account has been blocked. Please contact your administrator.");
            } else if (($otpType == 'signUp' && $user)) {
                throw new \ErrorException(__('messages.error.emailRegistered'));
            } else {
                $this->otp([
                    'email' => $data['email'],
                    'otpType' => $otpType
                ]);

                return true;
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Generate Otp
     *
     */
    protected function otp($data)
    {
        try {
            DB::beginTransaction();
            $otp = app()->environment([ServerEnum::Local, ServerEnum::Staging, ServerEnum::Acceptance]) ? '111111' : mt_rand(100000, 999999);

            $otpCode = Otp::where('emailPhoneNumber', $data['email'])->first();
            if ($otpCode) {
                $otpCode->delete();
            }

            $otpTypeValue = null;
            if ($data['otpType'] === 'signIn') {
                $otpTypeValue = OtpStatusEnum::SIGNIN_EMAIL_OTP;
            } elseif ($data['otpType'] === 'signUp') {
                $otpTypeValue = OtpStatusEnum::SIGNUP_EMAIL_OTP;
            }

            Otp::create([
                'emailPhoneNumber' => $data['email'],
                'otp' => $otp,
                'otpType' => $otpTypeValue,
            ]);

            // Send the OTP to the email
            Mail::to($data['email'])->send(new OtpMail($otp));

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Verify otp
     */
    public function verifyOtp($data, $otpType)
    {
        try {
            DB::beginTransaction();
            if (!in_array($otpType, ['signIn', 'signUp'])) {
                throw new \ErrorException(__('messages.error.invalidOtpType'));
            }
            $otpCode = Otp::where(['emailPhoneNumber' => $data['email'], 'otp' => $data['verificationCode']])->first();
            if (!($otpCode)) {
                throw new \ErrorException(__('messages.error.invalidOtpCode'));
            }

            // Check if the OTP has expired
            $otpCreatedTime = $otpCode->createdAt;

            // Parse $otpCreatedTime if it's not already a Carbon instance
            $otpCreatedTime = $otpCode->createdAt ? Carbon::parse($otpCode->createdAt) : null;

            // Calculate the difference in seconds
            $differenceInSeconds = $otpCreatedTime->diffInSeconds(Carbon::now('UTC'));

            if ($differenceInSeconds > 180) {
                $otpCode->delete();
                throw new \ErrorException(__('messages.error.expiredOtpCode'));
            }

            $otpCode->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException(($e->getMessage()));
        }
    }

    /**
     * Attempt LogIn
     */
    public function attemptLogIn($data)
    {
        try {
            $user = User::where('email', $data['email'])->first();

            if (!($user)) {
                throw new \ErrorException(__('messages.error.emailNotRegistered'));
            }

            // Check if the user has the "User" role
            if (!$user->hasRole('User')) {
                throw new \ErrorException(__('messages.error.invalidUserRole'));
            }

            if ($user->status == UserStatusEnum::BLOCK) {
                throw new \ErrorException(__('messages.error.blockedUser'));
            } else if ($user->status == UserStatusEnum::INACTIVE) {
                throw new \ErrorException(__('messages.error.inactiveUser'));
            } else if ($user->status == UserStatusEnum::ACTIVE) {
                Auth::login($user);
                if (Auth::check()) {
                    return true; // User is logged in
                } else {
                    throw new \ErrorException(__('messages.error.invalidCredentials'));
                }
            } else {
                throw new \ErrorException(__('messages.error.invalidUserStatus'));
            }
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    /**
     * Function to create user
     */
    public function createUser(array $data)
    {
        try {

            DB::beginTransaction();
            if (empty($data['userEmail'])) {
                throw new \ErrorException(__("messages.error.emailRequired"));
            }

            $user = User::where('email', $data['userEmail'])->first();
            if ($user) {
                throw new \ErrorException(__("messages.error.emailRegistered"));
            }

            $userRole = Role::where('name', 'User')->first(); // Here to modify

            $fileName = !empty($data['fileUpload']) ? $this->uploadFile($data['fileUpload'], '/upload/profile') : 'default_profile_image.png'; // Default image

            // Create user
            $user = User::create([
                'email' => $data['userEmail'],
                'firstName' => trim($data['firstName']),
                'password' => Hash::make('TechSwivel#001'),
                'lastName' => trim($data['lastName']),
                'jobTitle' => $data['jobTitle'],
                'organizationId' => $data['organizationId'],
                'organizationName' => $data['organization'],
                'departmentId' => $data['departmentId'],
                'departmentName' => $data['department'],
                'gmailId' => $data['googleId'],
                'appleId' => $data['appleId'],
                'image' => $fileName,
                'status' => UserStatusEnum::ACTIVE,
            ]);

            // Assign Role to User
            $user->assignRole($userRole);

            // Delete a single record matching the where clause
            Otp::where('emailPhoneNumber', $data['userEmail'])->delete();
            DB::commit();

            Auth::login($user);
            // Authentication passed...
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \ErrorException($e->getMessage());
        }
    }
}