<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rate Together Now  | Complete Profile</title>
    <link rel="icon" href="{{ asset('img/officialLogo.png') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- Select 2  CSS-->
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/auth/dropZone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">

    <link rel="stylesheet" href="{{ asset('css/user/auth/completeProfile.css') }}">
    <style>
    </style>
</head>

<body style="font-family: poppins;">
    <div class="container-fluid container-custom">
        <div class="row w-100">
            <!-- First Div with Image -->
            <div class="col-md-6 firstDiv MyfirstDiv d-flex justify-content-center align-items-center"
                style="background-color: #000000; min-height: 100vh;">
                <img src="{{ asset('img/rateMyPeerMainPic.jpeg') }}" class="img-fluid" alt="Image" id="mainImg"
                    style=" border-radius:8px; width: 100vh; height: 100vh;">
            </div>


            <!-- Form Section -->
            <div class="col-md-6 form-section d-flex flex-column align-items-center justify-content-center"
                style="background-color: white; padding: 20px;">
                <div class="text-left w-100">
                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto custmMargin">
                            <!-- Logo Here -->
                            <img src="{{ asset('img/officialLogo.png') }}" alt="Logo Here" class="imgLogo"
                                style="width: 56px; height: 56px; border-radius: 3px;">
                            <div class="form-group" style="margin-top: 20px;">
                                <h2><strong>Evaluate.<br>Improve. Empower.</strong></h2>
                                <p class="">Sign up to create your Rate Together Now  account.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row w-100">
                        <div class="col-12 col-sm-10 col-md-8 mx-auto">
                            <!-- Complete Profile Form -->
                            <form action="{{ route('user.auth.completeProfile') }}" method="POST"
                                enctype="multipart/form-data" id="completeSignUpForm">
                                @csrf
                                <!-- User Email -->
                                <!-- User Email or Google Email -->
                                @if (session('googleEmail'))
                                    <input type="hidden" id="userEmail" name="userEmail"
                                        class="form-control inputFieldHeight customBorderRadius"
                                        value="{{ session('googleEmail') }}" readonly>
                                @elseif (session('appleEmail'))
                                    <input type="hidden" id="userEmail" name="userEmail"
                                        class="form-control inputFieldHeight customBorderRadius"
                                        value="{{ session('appleEmail') }}" readonly>
                                @else
                                    <input type="hidden" id="userEmail" name="userEmail"
                                        class="form-control inputFieldHeight customBorderRadius"
                                        value="{{ session('userEmail') }}" readonly>
                                @endif
                                <input type="hidden" id="googleId" name="googleId"
                                    class="form-control inputFieldHeight customBorderRadius"
                                    value="{{ session('googleId') }}" readonly>
                                <input type="hidden" id="appleId" name="appleId"
                                    class="form-control inputFieldHeight customBorderRadius"
                                    value="{{ session('appleId') }}" readonly>

                                <!-- First and Last Name -->
                                <div class="form-row form-group mb-2">
                                    <div class="col-md-6">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="firstName" name="firstName"
                                            class="form-control inputFieldHeight customBorderRadius @error('firstName') is-invalid @enderror"
                                            placeholder="Enter first name" maxlength="255"
                                            value="{{ session('firstName') }}">
                                        <span class="invalid-feedback d-block" id="firstNameError"
                                            role="alert"></span>
                                        @error('firstName')
                                            <span class="invalid-feedback d-block"
                                                role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="lastName" name="lastName"
                                            class="form-control inputFieldHeight customBorderRadius @error('lastName') is-invalid @enderror"
                                            placeholder="Enter last name" maxlength="255"
                                            value="{{ session('lastName') }}">
                                        <span class="invalid-feedback d-block" id="lastNameError"
                                            role="alert"></span>
                                        @error('lastName')
                                            <span class="invalid-feedback d-block"
                                                role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Organization -->
                                <div class="form-group mb-2">
                                    <label for="organization">Organization</label>
                                    <input type="text" id="organization" name="organization"
                                        class="form-control inputFieldHeight customBorderRadius @error('organization') is-invalid-border-only @enderror"
                                        placeholder="Type to search organization">
                                    <!-- Hidden input to store selected organization ID -->
                                    <input type="hidden" id="organizationId" name="organizationId">

                                    <span class="invalid-feedback d-block" id="organizationError"
                                        role="alert"></span>
                                    @error('organization')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Department -->
                                <div class="form-group mb-2">
                                    <label for="department">Department</label>
                                    <input type="text" id="department" name="department"
                                        class="form-control inputFieldHeight customBorderRadius @error('department') is-invalid-border-only @enderror"
                                        placeholder="Type to search department">
                                    <!-- Hidden input to store selected department ID -->
                                    <input type="hidden" id="departmentId" name="departmentId">

                                    <span class="invalid-feedback d-block" id="departmentError"
                                        role="alert"></span>
                                    @error('department')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Job Title -->
                                <div class="form-group mb-2">
                                    <label for="jobTitle">Job Title</label>
                                    <input type="text" id="jobTitle" name="jobTitle"
                                        class="form-control inputFieldHeight customBorderRadius @error('jobTitle') is-invalid @enderror"
                                        placeholder="Enter your job title" maxlength="255"
                                        value="{{ old('jobTitle') }}">
                                    <span class="invalid-feedback d-block" id="jobTitleError" role="alert"></span>
                                    @error('jobTitle')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Profile Picture -->
                                <div class="form-row form-group mb-2 profilePictureRow">
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ asset('img/SignUpDefaultAvatar.png') }}" class="img-rounded"
                                            alt="avatar" id="profilePicture"
                                            style="height: 60px; width: 60px; border-radius: 200px; border: solid; border-color: aliceblue; object-fit: cover;">
                                    </div>
                                    <div class="profilePictureRightCol col-md-9">
                                        <div id="dropZone"
                                            style="border: solid; border-color: #EAECF0; border-radius: 10px; text-align: center; padding: 15px;">
                                            <img src="{{ asset('img/socialIcon/dragAndDropIcon.png') }}"
                                                alt="Drag & Drop" style="height: 60px; width: 60px;">
                                            <br>
                                            <input type="file" id="fileUpload" name="fileUpload"
                                                class="form-control" accept=".svg,.png,.jpg,.jpeg,.gif"
                                                style="display: none;">
                                            <span id="dropZoneText" style="font-size: smaller">
                                                <span class="text-blue"><strong>Click to upload</strong></span> or drag
                                                and
                                                drop<br>SVG, PNG, JPG or GIF
                                            </span>
                                        </div>
                                        <span class="invalid-feedback d-block" id="fileUploadError"
                                            role="alert"></span>
                                        @error('fileUpload')
                                            <span class="invalid-feedback d-block"
                                                role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Complete Sign Up -->
                                <div class="form-group mb-2">
                                    <button type="submit"
                                        class="btn btn-primary btn-block btnHeight customBorderRadius customBtnColor"
                                        id="btnCompleteProfile">
                                        Complete Sign Up
                                    </button>
                                </div>
                            </form>
                            <!-- /Complete Profile Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Jquery Version -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Jquery Validation -->
    <script src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script>
        var googleId = "{{ session('googleId') }}";
        var appleId = "{{ session('appleId') }}";
        var userEmail = "{{ session('googleEmail') ?: (session('appleEmail') ?: session('userEmail')) }}";

        var defaultAvatar = "{{ asset('img/SignUpDefaultAvatar.png') }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/user/auth/completeProfile.js') }}"></script>

    <script src="{{ asset('js/user/auth/completeProfileImageDragDrop.js') }}"></script>
    @include('common.layouts.compusoryToastrAlert')
    <script>
        // Pass the organizations data to JavaScript
        const organizations = @json($organizations);
    </script>
</body>

</html>
