@extends('common.layouts.master')
@section('title', 'Peer - Add')
@section('headerHeading', 'Add Peer')
@section('style')
    <!-- Select 2  CSS-->
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/customSelect2Box.css') }}">

    <!-- Custom CSS Add Peer -->
    <link rel="stylesheet" href="{{ asset('css/user/peer/addPeer.css') }}">
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
                                <span class="cardHeading btnStyles">Add Peer</span>
                                <p class="cardHeadingText" style="">
                                    Welcome to the Rate Together Now  Add Peer section! Here, you can add peers.
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('user.peer.savePeer') }}" method="POST" id="addPeerForm">
                            @csrf
                            <!-- 1st Row -->
                            <!-- First Name   ---  Last Name   -->
                            <div class="form-group row">
                                <!-- First Name -->
                                <div class="col-md-6">
                                    <label for="firstName" class="labelHeading">First Name</label>
                                    <input type="text" name="firstName" id="firstName" value="{{ old('firstName') }}"
                                        class="form-control inputFieldHeight customBorderRadius @error('firstName') is-invalid @enderror"
                                        placeholder="Enter Peer's First Name" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="firstNameError"
                                        role="alert"></span>
                                    @error('firstName')
                                        <span class="invalid-feedback d-block validationError" id="firstNameError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <label for="lastName" class="labelHeading">Last Name</label>
                                    <input type="text" name="lastName" id="lastName" value="{{ old('lastName') }}"
                                        class="form-control inputFieldHeight customBorderRadius @error('lastName') is-invalid @enderror"
                                        placeholder="Enter Peer's Last Name" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="lastNameError"
                                        role="alert"></span>
                                    @error('lastName')
                                        <span class="invalid-feedback d-block validationError" id="lastNameError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 2nd Row -->
                            <!-- Gender   ---  Ethnicity   -->
                            <div class="form-group row">
                                <!-- Gender -->
                                <div class="col-md-6">
                                    <label for="gender" class="labelHeading">Gender</label>
                                    <select id="gender" name="gender"
                                        class="form-control inputFieldHeight customBorderRadius @error('gender') is-invalid-border-only @enderror">
                                        <option value="" selected disabled>Enter Peer's Gender</option>
                                        @foreach ($genders as $gender)
                                            <option
                                                value="{{ $gender }}"{{ old('gender') == $gender ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower($gender)) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <span class="invalid-feedback d-block validationError" id="genderError"
                                        role="alert"></span>
                                    @error('gender')
                                        <span class="invalid-feedback d-block validationError" id="genderError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ethnicity -->
                                <div class="col-md-6">
                                    <label for="ethnicity" class="labelHeading">Ethnicity</label>
                                    <select id="ethnicity" name="ethnicity"
                                        class="form-control inputFieldHeight customBorderRadius @error('ethnicity') is-invalid-border-only @enderror">
                                        <option value="" selected disabled>Ethnicity</option>
                                        @foreach ($ethnicityStatuses as $ethnicity)
                                            <option
                                                value="{{ $ethnicity }}"{{ old('ethnicity') == $ethnicity ? 'selected' : '' }}>
                                                {{ ucfirst(strtolower(str_replace('_', ' ', $ethnicity))) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback d-block validationError" id="ethnicityError"
                                        role="alert"></span>
                                    @error('ethnicity')
                                        <span class="invalid-feedback d-block validationError" id="ethnicityError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 3rd Row -->
                            <!-- Organziation  --- Department -->
                            <div class="form-group row">
                                <!-- Organization -->
                                <div class="col-md-6">
                                    <label for="organizationId" class="labelHeading">Organization</label>
                                    <select id="organizationId" name="organizationId"
                                        class="form-control inputFieldHeight customBorderRadius organizationSelectBox @error('organizationId') is-invalid-border-only @enderror">
                                        <option value="" selected disabled>Enter Organization Name</option>
                                        @foreach ($organizations as $organization)
                                            <option value="{{ $organization->id }}"
                                                {{ $organizationId == $organization->id ? 'selected' : '' }}>
                                                {{ $organization->name }} - {{ $organization->address }}
                                            </option>
                                        @endforeach
                                        <option value="addNewOrganization" class="addNewOrganizationOption">Add New
                                            Organization</option>
                                    </select>
                                    <span class="invalid-feedback d-block validationError" id="organizationIdError"
                                        role="alert"></span>
                                    @error('organizationId')
                                        <span class="invalid-feedback d-block validationError" id="organizationIdError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>


                                <!-- Department -->
                                <div class="col-md-6">
                                    <label for="departmentId" class="labelHeading">Department</label>
                                    <select id="departmentId" name="departmentId"
                                        class="form-control inputFieldHeight customBorderRadius departmentSelectBox @error('departmentId') is-invalid-border-only @enderror">
                                        <option value="" selected disabled>Enter Department</option>

                                        {{-- Check if departments data exists --}}
                                        @if (isset($departments) && $departments->isNotEmpty())
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('departmentId') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <span class="invalid-feedback d-block validationError" id="departmentIdError"
                                        role="alert"></span>
                                    @error('departmentId')
                                        <span class="invalid-feedback d-block validationError" id="departmentIdError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <!-- 4th Row -->
                            <div class="form-group row">
                                <!-- Job Title -->
                                <div class="col-md-6">
                                    <label for="jobTitle" class="labelHeading">Job Title</label>
                                    <input type="text" name="jobTitle" id="jobTitle" value="{{ old('jobTitle') }}"
                                        class="form-control inputFieldHeight customBorderRadius @error('jobTitle') is-invalid @enderror"
                                        placeholder="Enter Job Title" autofocus>
                                    <span class="invalid-feedback d-block validationError" id="jobTitleError"
                                        role="alert"></span>
                                    @error('jobTitle')
                                        <span class="invalid-feedback d-block validationError" id="jobTitleError"
                                            role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- 5th Row -->
                            <div class="form-group row">
                                <!-- Add Peer Button --->
                                <div class="col-md-6 form-group">
                                    <button type="submit" id="btnAddPeer"
                                        class="btn btn-primary btn-block customBtnColor customBorderRadius btnHeight">
                                        <span>Add Peer</span>
                                    </button>
                                </div>

                                <!-- Cancel Button --->
                                <div class="col-md-6 from-group">
                                    <button type="reset" id="btnCancel"
                                        class="btn btn-block customBorderRadius btnHeight text-blue">
                                        <span>Cancel</span>
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

    @include('user.peer.modal.addPeerModal')

    <!-- Add New Department to Selected Organiztion -->
    @include('user.department.common.addDepartmentModal')

@endsection
@section('script')
    <!-- Jquery Validation -->
    <script type="text/javascript" src="{{ asset('jquery/jquery.validate.min.js') }}"></script>
    <!-- Select 2 JS -->
    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <!-- Script file to display loader  -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        var sessionAddPeer = "{{ session('peerSaved') ? 'true' : 'false' }}";
        var userLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
        // Global redirect back Url
        var redirectBackUrl = "{{ Auth::check() ? route('user.peer.listPeer') : route('peer.listPeer') }}";
    </script>

    <script type="text/javascript" src="{{ asset('js/user/peer/addPeer.js') }}"></script>
    <script>
        $('#organizationId').change(function() {
            // Get the selected value
            const selectedValue = $(this).val();

            // Check if "Add New Organization" is selected
            if (selectedValue === 'addNewOrganization') {
                // Redirect to your desired route
                window.location.href =
                    "{{ route('user.organization.addOrganizationForm') }}"; // Replace with your route name
            }
        });
    </script>

@endsection
