<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rate Together Now  | Sign-in</title>

    <link rel="icon" href="{{ asset('img/officialLogo.png') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('css/user/auth/signInSignUp.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/auth/imgResponsive.css') }}">
</head>

<body style="font-family: poppins;">
    <div class="container-fluid container-custom">
        <div class="row w-100">
            <div class="col-12  col-md-6 col-lg-6  firstDiv d-flex justify-content-center"
                style="background-color: #000000;  width:100%">
                <img src="{{ asset('img/rateMyPeerMainPic.jpeg') }}" class="img-responsive" alt="Image"
                    id="mainImg"
                    style=" margin: 10px; border-radius: 8px; width:100%;  height: 100vh; object-fit: cover;">
            </div>
            <div class="col-12  col-md-6 col-lg-6  form-section d-flex flex-column align-items-center justify-content-center"
                style="background-color: white">

                <div class="text-left w-100">
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto custmMargin">
                            <!-- Logo Here -->
                            <img src="{{ asset('img/officialLogo.png') }}" alt="Logo" class="imgLogo">
                            <div class="form-group mb-4" style="margin-top: 32px;">
                                <label class="mainHeading">Evaluate.<br>Improve. Empower.</label>
                                </br>
                                <label class="mainHeadingPara">
                                    Log in to your Rate Together Now account
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">
                            <div class="from-group mb-3">
                                <form action="{{ route('user.auth.provider', ['provider' => 'google']) }}"
                                    method="GET">
                                    <button type="submit" class="btn btn-block btn-outline customButton">
                                        <img src="{{ asset('img/socialIcon/googleLogo.png') }}" alt="Google">
                                        Continue with Google
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">
                            <div class="from-group mb-3">
                                <form action="{{ route('user.auth.provider', ['provider' => 'apple']) }}"
                                    method="GET">
                                    <button type="submit" class="btn btn-block btn-outline customButton">
                                        <img src="{{ asset('img/socialIcon/appleLogo.png') }}" alt="Apple">
                                        Continue with Apple
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">
                            <!-- Sing In Form -->
                            <form action="{{ route('user.auth.verifyOtp', ['otpType' => 'signIn']) }}" method="POST"
                                id="signInForm">
                                @csrf
                                <!-- User Email Here -->
                                <div class="form-group mb-2">
                                    <label for="email" class="labelForm">Email</label>
                                    @if (session('googleEmail'))
                                        <input type="email" name="email" id="email"
                                            class="form-control inputFieldHeight @error('email') is-invalid @enderror customBorderRadius"
                                            value="{{ session('googleEmail') }}" placeholder="Enter your email"
                                            maxlength="255" readonly
                                            @if ($errors->has('verificationCode')) readonly="readonly" style="cursor: pointer" @endif>
                                        @if (session('googleId'))
                                            <input type="hidden" name="googleId" id="googleId"
                                                class="form-control customBorderRadius"
                                                value="{{ session('googleId') }}" placeholder="Enter your google id"
                                                maxlength="255" readonly>
                                        @endif
                                    @elseif (session('appleEmail'))
                                        <input type="email" name="email" id="email"
                                            class="form-control inputFieldHeight @error('email') is-invalid @enderror customBorderRadius"
                                            value="{{ session('appleEmail') }}" placeholder="Enter your email"
                                            maxlength="255" readonly
                                            @if ($errors->has('verificationCode')) readonly="readonly" @endif>
                                        @if (session('appleId'))
                                            <input type="hidden" name="appleId" id="appleId"
                                                class="form-control customBorderRadius"
                                                value="{{ session('appleId') }}" placeholder="Enter your google id"
                                                maxlength="255" readonly>
                                        @endif
                                    @else
                                        <input type="email" name="email" id="email"
                                            class="form-control inputFieldHeight @error('email') is-invalid @enderror customBorderRadius"
                                            value="{{ old('email') }}" placeholder="Enter your email"
                                            maxlength="255"
                                            @if ($errors->has('verificationCode')) readonly="readonly" style="cursor: pointer" @endif>
                                    @endif
                                    <span class="invalid-feedback d-block" id="emailError" role="alert"></span>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group mb-2" style="margin-top: 10px">
                                        <button type="submit" class="btn btn-primary btn-block btnHeight"
                                            id="btnEmail"
                                            @if (session('googleEmail') || session('appleEmail')) style="display: none;" @endif
                                            @if ($errors->has('verificationCode')) style = "display: none;" @endif>Continue</button>
                                    </div>
                                </div>

                                <!-- User Verification Code Here -->
                                <div class="form-group mb-2" id="verificationDiv"
                                    @if (session('googleEmail') || session('appleEmail')) style="{{ $errors->has('verificationCode') ? 'display: none;' : 'display: block;' }}"
                                        @else
                                        style="{{ $errors->has('verificationCode') ? 'display: block;' : 'display: none;' }}" @endif>
                                    <label for="verificationCode" class="labelForm">Verfication Code</label>
                                    <input type="text" name="verificationCode" id="verificationCode"
                                        minlength="6" maxlength="6"
                                        class="form-control inputFieldHeight customBorderRadius @error('verificationCode') is-invalid @enderror"
                                        placeholder="Enter code" pattern="[0-9]*"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                    <span class="invalid-feedback d-block" id="verificationCodeError"
                                        role="alert"></span>
                                    @error('verificationCode')
                                        <span class="invalid-feedback d-block" id="backendVerificationCodeError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                    <div id="divResendCode">
                                        <label class="labelResend">
                                            We sent you a code to your inbox. <a href="#"
                                                id="resendVerificationCode"
                                                @if ($errors->has('verificationCode')) @else
                                            style="display: none;" @endif>Resend</a>
                                            <span id="timer" style="text-align: end; display:none;">59s</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <button type="submit" class="btn btn-primary btn-block btnHeight"
                                        id="btnContinue"
                                        @if (session('googleEmail') || session('appleEmail')) style="display: block;";
                                        @else
                                            @if ($errors->has('verificationCode'))
                                                style = "display: block;"
                                            @else
                                                style="display: none;" @endif
                                        @endif>
                                        Continue
                                    </button>
                                </div>
                                <div class="form-group manageDiv">
                                    <label class="labelForm">Don't have an account? <a
                                            href="{{ route('user.auth.signUpForm') }}" class="manageSignUp">Sign
                                            Up</a></label>
                                </div>
                                <div class="form-group manageDiv1" style="text-align: center;">
                                    <a href="{{ route('home.index') }}" class="manageBacktoHome">Back to
                                        Home</a></label>
                                </div>
                            </form>
                            <!-- / Sign in Form Closes Here  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.auth.emailAlertModal')

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Jquery Version -->
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript">
        var sessionSocialAuth = "{{ session('googleEmail') || session('appleEmail') ? 'true' : 'false' }}";


        // Define a global variable
        @if ($errors->has('verificationCode'))
            var sendOtpCodeStatus = false;
        @else
            var sendOtpCodeStatus = true;
        @endif
    </script>
    <script type="text/javascript" src="{{ asset('js/user/auth/signIn.js') }}"></script>
    <!-- Bootstrap Js file to Show modal -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    @include('common.layouts.compusoryToastrAlert')
</body>

</html>
