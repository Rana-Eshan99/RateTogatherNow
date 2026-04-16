<?php

namespace App\Http\Controllers\User\Auth;

use session;
use Exception;
use App\Services\SocialService;
use App\Services\ErrorLogService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\User\Auth\SendOtpRequest;
use App\Http\Requests\User\Auth\VerifyOtpRequest;
use App\Http\Requests\User\Auth\UserSignUpRequest;
use App\Repositories\Interfaces\User\Auth\AuthInterface;
use App\Repositories\Repositories\User\Auth\AuthRepository;
use App\Repositories\Interfaces\User\Organization\OrganizationInterface;
use App\Repositories\Repositories\User\Organization\OrganizationRepository;

class AuthController extends Controller
{
    /**
     * The repository instance
     *
     * @var AuthRepository
     */
    private $authRepository;

    /**
     * The repository instance
     *
     * @var OrganizationRepository
     */
    private $organizationRepository;

    /**
     * The service instance
     *
     * @var SocialService
     */
    private $socialService;

    /**
     * AuthController Constructor
     *
     * @param AuthRepository $authRepository
     * @param OrganizationRepository $organizationRepository
     * @param SocialService $socialService
     */
    public function __construct(AuthInterface $authRepository, OrganizationInterface $organizationRepository, SocialService $socialService)
    {
        $this->authRepository = $authRepository;
        $this->organizationRepository = $organizationRepository;
        $this->socialService = $socialService;
    }

    /**
     * Show the login page
     */
    public function signInForm()
    {
        try {
            return view('user.auth.signIn');
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Send otp for signIn or signUp
     *
     */
    public function sendOtp(SendOtpRequest $request, $otpType)
    {
        try {
            $this->authRepository->sendOtp($request->all(), $otpType);
            return response()->json([
                'response' => [
                    'status' => true,
                    'message' => 'Verification code has been sent successfully',
                ],
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return response()->json([
                'response' => [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verify Otp and perform actions accordingly
     */
    public function verifyOtp(VerifyOtpRequest $request, $otpType)
    {
        try {
            $this->authRepository->verifyOtp($request->all(), $otpType);
            if ($otpType == "signIn") {
                $this->authRepository->attemptLogIn($request->all());
                // The user is logged in
                return redirect()->route('user.dashboard.index');
            } else {
                session([
                    'userEmail' => $request->email,
                    'googleId' => $request->googleId,
                    'appleId' => $request->appleId,
                ]);
                return redirect()->route('user.auth.profileForm');
            }
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the SignUp page
     */
    public function signUpForm()
    {
        try {
            return view('user.auth.signUp');
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show completeProfile page
     */
    public function profileForm()
    {
        try {
            $organizations = $this->organizationRepository->getOrganizations();
            return view('user.auth.completeProfile', compact('organizations'));
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     *  Save the Complete Profile of Peer(User)
     */
    public function completeProfile(UserSignUpRequest $request)
    {
        try {
            $this->authRepository->createUser($request->all());
            return redirect()->route('user.dashboard.index');
        } catch (Exception $e) {
            ErrorLogService::errorLog($e);
            return redirect()->route('user.auth.signUpForm')->with('error', $e->getMessage());
        }
    }

    /**
     * Redirect to social authentication.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(string $provider): RedirectResponse
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Handle the callback from social authentication.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(string $provider): RedirectResponse
    {
        try {
            $callBackResult = $this->socialService->handleCallback($provider);
            return $this->handleCallbackResult($callBackResult, $provider);
        } catch (Exception $e) {

            return redirect()->route('user.auth.signInForm')->with('error', $e->getMessage());
        }
    }

    /**
     * Handle the callback result.
     *
     * @param array $callBackResult
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleCallbackResult(array $callBackResult, string $provider): RedirectResponse
    {
        try {
            $emailKey = $provider . 'Email';
            $providerIdKey = $provider . 'Id';
            if ($callBackResult['status'] === ($provider === 'google' ? 'GoogleSignUpSuccess' : 'AppleSignUpSuccess')) {
                $redirect = redirect()->route('user.auth.profileForm')
                    ->with($emailKey, $callBackResult['email'])
                    ->with($providerIdKey, $callBackResult['providerId']);
                // Pass first and last name only if provider is Google
                if ($provider === 'google') {
                    $redirect->with('firstName', $callBackResult['firstName'])
                        ->with('lastName', $callBackResult['lastName']);
                }
                return $redirect;
            } elseif ($callBackResult['status'] === ($provider === 'google' ? 'GoogleSignInSuccess' : 'AppleSignInSuccess')) {

                $this->authRepository->attemptLogIn($callBackResult);
                return redirect()->route('user.dashboard.index');
            }
        } catch (Exception $e) {
            return redirect()->route('user.auth.signInForm')->with('error', $e->getMessage());
        }
    }
}
