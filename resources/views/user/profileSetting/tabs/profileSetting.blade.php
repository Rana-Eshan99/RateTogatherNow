<div id="profileSettingDiv">
    <div class="form-grow row d-flex" style="margin-bottom: 32px">
        <div class="col-md-10">
            <span class="cardHeading">Profile</span>
            <p class="" style="font-size:16px;font-weight:400; color: #00000080;">
                Welcome to the Rate Together Now  Profile section! Here, you can update your profile.
            </p>
        </div>

        <!-- Edit Profile Button -->
        <div class="col-md-2 justify-content-center" style="text-align: end">
            <button class="btn btn-primary" id="editProfile" style="">
                Edit Profile
            </button>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <form action="{{ route('user.profileSetting.update') }}" method="POST" enctype="multipart/form-data"
        id="editProfileForm">
        @method('PUT')
        @csrf
        <!-- 1st Row -->
        <div class="form-group row d-flex justify-content-left" style="margin-bottom: 20px">
            <!-- Avatar and Camera Icon Container -->
            <div class="col">
                <div class="position-relative" style="width: 72px; height: 72px;">
                    <!-- Avatar Image -->
                    <img id="avatarImage" src="{{ Auth::user()->getAvatarFullUrlAttribute() }}" alt="Avatar"
                        class="img-responsive"
                        onerror="this.onerror=null;this.src='{{ asset('img/SignUpDefaultAvatar.png') }}';">

                    <!-- Camera Icon Overlay -->
                    <div class="position-absolute cameraIconOverlay" style="cursor:not-allowed">
                        <img src="{{ asset('img/socialIcon/photoUploadIcon.png') }}" alt="Photo"
                            class="insideCameraIcon" style="cursor: not-allowed">
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="fileUpload" name="fileUpload" style="display: none;" accept="image/*">
                </div>
                <span class="invalid-feedback d-block validationError" id="fileUploadError" role="alert"></span>
                @error('fileUpload')
                    <span class="invalid-feedback d-block validationError" id="fileUploadError" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <!-- 2nd Row -->
        <div class="form-group row mb-2">
            <!-- First Name -->
            <div class="col-md-6">
                <label for="firstName" class="labelHeading">First Name</label>

                <input type="text" name="firstName" id="firstName"
                    value="{{ old('firstName') ?? Auth::user()->firstName }}" placeholder="Enter first name" disabled
                    class="form-control inputFieldHeight customBorderRadius @error('firstName') is-invalid @enderror"
                    autofocus>
                <span class="invalid-feedback d-block validationError" id="firstNameError" role="alert"></span>
                @error('firstName')
                    <span class="invalid-feedback d-block validationError" id="firstNameError" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="col-md-6">
                <label for="lastName" class="labelHeading">Last Name</label>
                <input type="text" name="lastName" id="lastName" placeholder="Enter last name" autofocus disabled
                    value="{{ old('lastName') ?? Auth::user()->lastName }}"
                    class="form-control inputFieldHeight customBorderRadius @error('lastName') is-invalid @enderror">
                <span class="invalid-feedback d-block validationError" id="lastNameError" role="alert"></span>
                @error('lastName')
                    <span class="invalid-feedback d-block validationError" id="lastNameError" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <!-- 3rd Row -->
        <div class="form-group row mb-2">

            <!-- Email Name -->
            <div class="col-md-6">
                <label for="email" class="labelHeading">Email</label>
                <input type="text" autofocus disabled
                    value="{{ Auth::user()->email }}"
                    class="form-control inputFieldHeight customBorderRadius">
            </div>

            <!-- Organization -->
            <div class="col-md-6">
                <label for="organizationId" class="labelHeading">Organization Name</label>
                <input type="text" id="organization" name="organization"
                    class="form-control inputFieldHeight customBorderRadius @error('organization') is-invalid @enderror"
                    placeholder="Type to search organization" value="{{ Auth::user()->organizationName }}">

                <!-- Hidden input to store selected organization ID -->
                <input type="hidden" id="organizationId" name="organizationId"
                    value="{{ Auth::user()->organizationId ?? '' }}">


                <span class="invalid-feedback d-block validationError" id="organizationError" role="alert"></span>
                @error('organization')
                    <span class="invalid-feedback d-block validationError" id="organizationError"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>


        </div>

        <!-- 4th Row -->
        <div class="form-group row mb-2">
            <!-- Department -->
            <div class="col-md-6">
                <label for="departmentId" class="labelHeading">Department</label>
                <input type="text" id="department" name="department"
                    class="form-control inputFieldHeight customBorderRadius @error('department') is-invalid @enderror"
                    placeholder="Type to search department" value="{{ Auth::user()->departmentName }}">

                <!-- Hidden input to store selected department ID -->
                <input type="hidden" id="departmentId" name="departmentId"
                    value="{{ Auth::user()->departmentId ?? '' }}">

                <span class="invalid-feedback d-block validationError" id="departmentError" role="alert"></span>
                @error('department')
                    <span class="invalid-feedback d-block validationError" id="departmentError"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
            <!-- Job Title -->
            <div class="col-md-6">
                <label for="jobTitle" class="labelHeading">Job Title</label>
                <input type="text" id="jobTitle" name="jobTitle" placeholder="Enter your job title" disabled
                    class="form-control inputFieldHeight customBorderRadius @error('jobTitle') is-invalid @enderror"
                    value="{{ old('jobTitle') ?? Auth::user()->jobTitle }}">
                <span class="invalid-feedback d-block validationError" id="jobTitleError" role="alert"></span>
                @error('jobTitle')
                    <span class="invalid-feedback d-block validationError" id="jobTitleError"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <!-- 5th Row -->
        <div class="form-group row mb-2">
            <div class="col">
                <button type="submit" id="saveChangesBtn"
                    class="btn btn-block btnHeight saveBtnDisable customBorderRadius" style="display: none" disabled>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>
    </form>
    <!-- /......... Edit Profile Form -->
</div>
<!-- /........ Profile Setting content goes here -->

<!-- Add New Department to Selected Organiztion -->
@include('user.department.common.addDepartmentModal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Pass organizations data to JavaScript
    const organizationsData = @json(
        $organizations->map(function ($organization) {
            return [
                'name' => $organization->name,
                'id' => $organization->id,
            ];
        }));
</script>
<script>
    $(document).ready(function() {
        // Define department data for autocomplete; replace with AJAX if needed
        const departments = [
            @foreach ($departments as $department)
                {
                    label: "{{ $department->name }}",
                    value: "{{ $department->id }}"
                },
            @endforeach
        ];

        // Initialize jQuery UI Autocomplete
        $('#department').autocomplete({
            source: departments,
            select: function(event, ui) {
                $('#department').val(ui.item.label);
                $('#departmentId').val(ui.item
                    .value);
                return false;
            }
        });
    });
</script>
