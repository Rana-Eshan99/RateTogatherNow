<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Enums\UserStatusEnum;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\PasswordResetResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Contracts\PasswordResetResponse as PasswordResetResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $user = Auth::user();
                if ($user->hasRole('Admin')) {
                    return redirect()->route('admin.dashboard.index');
                } else {
                    Auth::logout();
                    $loginPath = Route::current();
                    if ($loginPath->uri() == '/admin/dashboard') {
                        toastr()->error('You don t have access panel');
                        return redirect()->route('adminSignInForm');
                    } else {
                        return redirect()->route('adminSignInForm')->with('error', 'Invalid login details');
                    }
                }
            }
        });
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                $loginPath = URL::previous();
                // admin dashboard route is /admin/dashboard
                if (strpos($loginPath, 'admin') !== false) {
                    return redirect()->route('adminSignInForm');
                } else {
                    return redirect()->to('/home');
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        // SuperAdmin login view
        Fortify::loginView(function () {
            return view('dashboard.auth.adminSignIn');
        });
        Fortify::authenticateUsing(function (Request $request) {
            // Retrieve the admin role
            $adminRole = Role::where('name', 'Admin')->first();

            // Check if the user with the given email has the 'Admin' role
            $user = User::where('email', $request->email)
                ->whereHas('roles', function ($query) use ($adminRole) {
                    $query->where('id', $adminRole->id);
                })
                ->first();
            if (!isset($user)) {
                throw ValidationException::withMessages([
                    Fortify::username() => [trans('Email not registered. Please try again.')],
                ]);
            }
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->status == UserStatusEnum::BLOCK) {
                    throw ValidationException::withMessages([
                        Fortify::username() => [trans('Your account has been blocked. Please contact your administrator.')],
                    ]);

                    return false;
                }
                return $user;
            } else {
                throw ValidationException::withMessages([
                    'password' => [trans('Invalid password. Please try again.')],
                ]);
            }
        });
        /* return your custom view for signup */
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
            ->middleware(['web'])
            ->name('password.request');
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['web'])
            ->name('password.email');
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
            ->middleware(['web'])
            ->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['web'])
            ->name('password.update');

        /* custom password reset login */
        Fortify::requestPasswordResetLinkView(function () {
            return view('dashboard.auth.forgotPassword');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('dashboard.auth.restPassword', ['request' => $request]);
        });
        Fortify::verifyEmailView(function () {
            return view('auth.passwords.confirm');
        });
        // Customizing the reset password logic after reset password to redirect to the adminSignInForm route
        $this->app->singleton(PasswordResetResponseContract::class, PasswordResetResponse::class);
    }
}