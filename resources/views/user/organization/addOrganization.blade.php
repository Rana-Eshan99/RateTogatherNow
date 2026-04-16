@extends('common.layouts.master')
@section('title', 'Organization - Add')
@section('headerHeading', 'Add Organization')
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/auth/dropZone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/organization/addOrganization.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <br>
            <!-- Default box -->
            <div class="card customParentCardStyle">
                <div class="card-body">
                    <div>
                        <div class="form-grow row">
                            <div class="col">
                                <span class="cardHeading">Add Organization</span>
                                <p class="cardHeadingText">
                                    Welcome to the Rate Together Now  Add Organization section! Here, you can add organizations.
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('user.organization.saveOrganization') }}" method="POST"
                            enctype="multipart/form-data" id="addOrganizationForm">
                            @csrf
                            <!-- 1st Row -->
                            <div class="form-group row">
                                <!-- Left column with content -->
                                <div
                                    class="col-md-6 col-sm-12 d-flex flex-column flex-sm-row align-items-center justify-content-start">
                                    <!-- Organization logo -->
                                    <div
                                        class="d-flex align-items-center mb-sm-0 mb-3 justify-content-start w-sm-auto align-self-start">
                                        <img src="{{ asset('img/organizationAddFormAvatar.png') }}" alt="Logo"
                                            class="img-rounded" id="organizationAvatar">
                                    </div>

                                    <!-- Upload box -->
                                    <div id="dropZone" class="d-flex align-items-start mt-sm-0" >
                                        <div class="mb-2" style="display: none;">
                                            <img src="{{ asset('img/upload-cloud.png') }}" alt="File"
                                                class="img-rounded" id="fileUploadLogo">
                                        </div>
                                        <input type="file" id="fileUpload" name="fileUpload" class="form-control"
                                            accept=".svg,.png,.jpg,.jpeg,.gif" style="display: none;">
                                        <span id="dropZoneText" class="text-start"
                                            style="font-size:14px; font-weight:400;color: #475467;">
                                            <span style="color:#0678E9; font-weight:600;">
                                                Click to upload logo
                                            </span> or drag and drop<br>
                                            SVG, PNG, JPG or GIF
                                        </span>
                                    </div>
                                </div>



                                <!-- Right column, intentionally blank -->
                                <div class="col-md-6"></div>

                                <div class="form-group-row mb-1">
                                    <div class="col-md-12">
                                        <span class="invalid-feedback d-block validationError" id="fileUploadError"
                                            role="alert"></span>
                                        @error('fileUpload')
                                            <span class="invalid-feedback d-block validationError"
                                                role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- 2nd Row -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="labelHeading">Organization Name</label>
                                    <input type="text" name="organizationName" id="organizationName"
                                        class="form-control inputFieldHeight customBorderRadius topMargin @error('name') is-invalid @enderror"
                                        value="{{ old('organizationName') }}" placeholder="Enter Organization Name"
                                        autofocus>
                                    <span class="invalid-feedback d-block validationError" id="organizationNameError"
                                        role="alert"></span>
                                    @error('organizationName')
                                        <span class="invalid-feedback d-block validationError" id="organizationNameError"
                                            role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="labelHeading">Country</label>
                                    <input type="text" name="country" id="country" readonly
                                        class="form-control inputFieldHeight customBorderRadius topMargin @error('country') is-invalid @enderror"
                                        value="{{ old('country') }}" placeholder="Enter country" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="countryError"
                                        role="alert"></span>
                                    @error('country')
                                        <span class="invalid-feedback d-block validationError" id="countryError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 3rd Row -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="labelHeading">State or Province</label>
                                    <input type="text" name="state" id="state" readonly
                                        class="form-control inputFieldHeight customBorderRadius topMargin @error('state') is-invalid @enderror"
                                        value="{{ old('state') }}" placeholder="Enter State or Province" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="stateError"
                                        role="alert"></span>
                                    @error('state')
                                        <span class="invalid-feedback d-block validationError" id="stateError" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="labelHeading">City</label>
                                    <input type="text" name="city" id="city" readonly
                                        class="form-control inputFieldHeight customBorderRadius topMargin @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}" placeholder="Enter City" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="cityError"
                                        role="alert"></span>
                                    @error('city')
                                        <span class="invalid-feedack d-block validationError" id="cityError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 4th Row -->
                            <!-- Blade Template -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="labelHeading">Street Address</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control address inputFieldHeight customBorderRadius topMargin @error('city') is-invalid @enderror"
                                        value="{{ old('address') }}" placeholder="Enter Street Address" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="addressError"
                                        role="alert"></span>
                                    @error('address')
                                        <span class="invalid-feedback d-block validationError" id="addressError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div id="address-map-container mb-4" style="width:100%;height:400px;">
                                <div style="width: 100%; height: 100%" id="address-map"></div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                            <!-- 5th Row -->
                            <div class="form-group row mt-4">
                                <div class="col-md-6 form-group">
                                    <button
                                        class="btn btn-primary btn-block customBtnColor customBorderRadius btnHeight btnStyles"
                                        type="submit" id="btnAddOrganization">Add Organization
                                    </button>
                                </div>
                                <div class="col-md-6 from-group">
                                    <button class="btn btn-block customBorderRadius btnHeight text-blue" type="reset"
                                        id="btnCancel" style="">Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.card -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('user.organization.modal.addOrganizationModal')

@endsection
@section('script')
    <!-- Jquery Validation -->
    <script src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Script file to display loader  -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        var defaultAddOrganizationFormAvatar = "{{ asset('img/organizationAddFormAvatar.png') }}";
        var sessionAddOrganization = "{{ session('organizationSaved') ? 'true' : 'false' }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
        // Global redirect back Url
        var redirectBackUrl =
            "{{ Auth::check() ? route('user.organization.listOrganization') : route('organization.listOrganization') }}";
    </script>

    <script src="{{ asset('js/user/organization/addOrganization.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/user/organization/addOrganizationLogoDragDrop.js') }}" type="text/javascript"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places" async defer>
    </script>

    <script>
        var Key = "{{ env('GOOGLE_MAP_API_KEY') }}";
    </script>
@endsection
