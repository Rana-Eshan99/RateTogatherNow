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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard/auth/signIn.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/auth/adminSignIn.css') }}">
</head>

<body style="font-family: Source Sans 3;">
    <div class="container-fluid container-custom">
        <div class="row w-100">
            <div class="col-md-6 image-section d-flex justify-content-center" style="background-color: #000000">
                <img src="{{ asset('img/rateMyPeerMainPic.jpeg') }}" class="img-responsive" alt="Image Here"
                    style="object-fit: cover;">
            </div>
            <div class="col-md-6 form-section   d-flex flex-column align-items-center justify-content-center"
                style="background-color: white">

                <div class="text-left w-100">
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">

                            <!-- Logo Here -->
                            <img src="{{ asset('img/officialLogo.png') }}" alt="Logo Here" class="imgLogo"
                                style="width: 56px; height: 55.53px; gap: 0px; border-radius:2.98px; opacity: 0px; ">
                            <div class="form-group mb-4" style="margin-top: 32px;">
                                <h2 class="title">Evaluate.<br>Improve. Empower.</h2>
                                <p class="discription">Log in to your admin panel account.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">
                            <!-- Sing In Form -->
                            <form action="{{ route('login') }}" method="POST" id="signinForm">
                                @csrf
                                <!-- User Email Here -->
                                <div class="form-group mb-2">
                                    <span class="feild-title">Email</span>
                                    <input type="email" name="email" id="email"
                                        class="form-control inputFieldHeight customBorderRadius @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="xyz@hotmail.com">
                                    <span class="invalid-feedback d-block" id="emailError" role="alert">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>

                                    <div class="form-group mb-2 mt-4 position-relative">
                                        <span class="feild-title">Password</span>

                                        <!-- Password input wrapped in a div to keep the icon aligned with it -->
                                        <div class="position-relative">
                                            <input type="password" name="password" id="password"
                                                class="form-control inputFieldHeight customBorderRadius"
                                                value="{{ old('password') }}" placeholder="Enter your password">

                                            <!-- Eye Icon for Toggling Password Visibility -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none"
                                                style="right: 10px; top: 50%; transform: translateY(-50%); position: absolute; cursor: pointer;">
                                                <image id="toggle_pwd" xlink:href="{{ asset('img/eye-slash.svg') }}"
                                                    width="24" height="24" />
                                            </svg>
                                        </div>
                                        <span class="invalid-feedback d-block" id="passwordError" role="alert">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="form-group mb-4 mt-4 mycustomForgot" style="text-align: end;">
                                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                                    </div>
                                    <div class="form-group mb-2" style="margin-top: 10px">
                                        <button type="submit"
                                            class="btn btn-primary btn-block btnHeight customBorderRadius customBtnColor"
                                            id="btnEmail">Continue</button>
                                    </div>

                                </div>
                            </form>
                            <!-- / Sign in Form Closes Here  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Jquery Version -->
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="{{ asset('js/dashboard/auth/adminSignIn.js') }}"></script>
    @if (session('status'))
        <script>
            toastr.success("{{ session('status') }}");
        </script>
    @endif

    <script>
        const eyeSvgSlashUrl = "{{ asset('img/eye-slash.svg') }}";
        const eyeSvgUrl = "{{ asset('img/eye.svg') }}";
    </script>

</body>

</html>
