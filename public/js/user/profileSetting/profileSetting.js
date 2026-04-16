$(document).ready(function () {

    // Department Select
    initializeDepartmentSelectBox();

    // To Initialize Department Select box and Add Custom Option Add Organization at the end
    function initializeDepartmentSelectBox() {

        $(".departmentSelectBox").select2({
            placeholder: 'Select department',
            width: '100%', // Set the width as per your requirement
            templateResult: function (state) {
                // Create a custom option with specific styles
                if (!state.id) {
                    return state.text;
                }
                var $state = $('<span>' + state.text + '</span>');
                if (state.id === 'addDepartment') {
                    $state = $(
                        '<span><i class="fas fa-plus" style="margin-right: 10px;height:24px;width:24px"></i>' + state.text + '</span>'
                    ).css({
                        'color': '#0678E9',
                        'font-size': '16px',
                        'font-weight': '500',
                    });

                    // Add hover effect
                    $state.hover(
                        function () {
                            $(this).css('color', '#FFFFFF');
                        },
                        function () {
                            $(this).css('color', '#0678E9');
                        }
                    );
                }
                return $state;
            },
            templateSelection: function (state) {
                return state.text;
            }
        });


        // Append the custom option at the end
        var newOption = new Option('Add Department', 'addDepartment', false, false);
        $('.departmentSelectBox').append(newOption).trigger('change');

    }

    // Initially disable the update button on the basis of edit button
    if (editProfile == true) {
        toggleInputFields(false);   // Set the input fields to edit.
        $("#editProfile").hide();
        $("#saveChangesBtn").prop("disabled", false).show().removeClass().addClass("btn btn-block btnHeight saveBtnEnable customBorderRadius");
    } else {
        toggleInputFields(true);    // Set the input fields to readonly and disabled
        $("#editProfile").show();
        $("#saveChangesBtn").prop("disabled", true).hide().removeClass().addClass("btn btn-block btnHeight saveBtnDisable customBorderRadius");
    }


    // jQuery to handle the click event and image preview
    // Trigger file input when camera icon is clicked
    $('.cameraIconOverlay').on('click', function () {
        if (editProfile == true) {
            $('#fileUpload').click();
        }
    });

    // Update avatar image when a new file is selected
    $('#fileUpload').on('change', function (event) {
        $("#fileUploadError").text('');
        const newAvatar = event.target.files[0];
        if (newAvatar) {
            if (validateFile(newAvatar) == true) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatarImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(newAvatar);
            }
        }
        else {
            $('#avatarImage').attr('src', userAvatarUrl);
        }
    });

    // Validate the newly selected avatar
    function validateFile(file) {
        var validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        var maxSize = 1 * 15360 * 1024; // 15MB
        var fileUploadError = $("#fileUploadError");

        if (!validTypes.includes(file.type)) {
            fileUploadError.text('Invalid file type. Only SVG, PNG, JPG, and GIF are allowed.').show();
            return false;
        }

        if (file.size > maxSize) {
            fileUploadError.text('File size exceeds 15MB.').show();
            return false;
        }

        // Clear previous error message
        fileUploadError.text('').hide();
        return true;
    }

    // .......... jQuery to handle the click event and image preview

    // Handle Edit
    $("#editProfile").click(function (e) {
        e.preventDefault();
        if (editProfile == false) {
            toggleInputFields(false);
            $("#saveChangesBtn").prop("disabled", true).show().removeClass().addClass("btn btn-block btnHeight saveBtnDisable customBorderRadius");
            $("#editProfile").hide();
            $('.insideCameraIcon').css('cursor', 'pointer');
            $('.cameraIconOverlay').css('cursor', 'pointer');
            editProfile = true;
        }
    });

    function toggleInputFields(type) {
        $("#firstName").attr('disabled', type);
        $("#lastName").attr('disabled', type);
        $("#organization").attr('disabled', type);
        $("#department").attr('disabled', type);
        $("#jobTitle").attr('disabled', type);
    }


    // Ensure the organizationsData is available
    const organizations = typeof organizationsData !== 'undefined' ? organizationsData : [];

        // Format organization data for jQuery UI Autocomplete
        const organizationSuggestions = organizations.map(org => ({
            label: org.name,
            value: org.id
        }));

        let isOrganizationSelected = false;

        $('#organization').autocomplete({
            minLength: 0, // Allows the autocomplete to show on focus even without typing
            source: function (request, response) {
                const results = request.term ? $.ui.autocomplete.filter(organizationSuggestions, request.term) : organizationSuggestions;
                response(results);
            },
            select: function (event, ui) {
                // Set the flag to true when an organization is selected
                isOrganizationSelected = true;

                // Set the organization name and ID
                $('#organization').val(ui.item.label);
                $('#organizationId').val(ui.item.value);
                $("#organizationError").html("").hide();

                // Clear department fields on selecting a new organization
                $('#department').val('').autocomplete({
                    source: []
                });
                $('#departmentId').val('');

                // Send AJAX call to fetch departments for the selected organization
                sendDepartmentAjaxRequest(ui.item.value);

                return false;
            }
        });

        // Show all organizations on focus
        $('#organization').on('focus', function () {
            $(this).autocomplete("search", "");
        });

        // Trigger AJAX call on organization field input to update departments
        $('#organization').on('input', function () {
            const organizationId = $('#organizationId').val();

            // Only send AJAX if an organization was selected and not modified manually
            if (isOrganizationSelected && organizationId) {
                // Clear the selection flag for next time
                isOrganizationSelected = false;

                // Clear department fields for a new search
                $('#department').val('').autocomplete({
                    source: []
                });
                $('#departmentId').val('');
            } else {
                // If modified manually, clear the organizationId and reset department fields
                $('#organizationId').val('');
                $('#department').val('').autocomplete({
                    source: []
                });
                $('#departmentId').val('');
            }
        });

        // Function to send AJAX request for department suggestions
        function sendDepartmentAjaxRequest(organizationId) {
            $("#saveChangesBtn").prop("disabled", false).show().removeClass().addClass("btn btn-block btnHeight saveBtnEnable customBorderRadius");
            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                url: `/department/get-departments/${organizationId}`,
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if (response.response.status) {
                        let departments = response.response.departments;

                        if (departments.length > 0) {
                            let departmentSuggestions = departments.map(dept => ({
                                label: dept.name,
                                value: dept.id
                            }));

                            // Initialize or update autocomplete for department field
                            $('#department').autocomplete({
                                minLength: 0, // Allows the autocomplete to show on focus even without typing
                                source: departmentSuggestions,
                                select: function (event, ui) {
                                    $('#department').val(ui.item.label);
                                    $('#departmentId').val(ui.item.value);
                                    return false;
                                }
                            });

                            // Show all departments on focus
                            $('#department').on('focus', function () {
                                $(this).autocomplete("search", "");
                            });
                        } else {
                            $('#department').autocomplete({
                                source: []
                            });
                        }
                    }
                },
                error: function (xhr) {
                    $.LoadingOverlay("hide");
                    console.error("Failed to load departments", xhr);
                    $("#organizationError").html("Failed to load departments.").show();
                }
            });
        }


    // Form Validation
    $('#saveChangesBtn').click(function (e) {
        $(".validationError").text("").hide();
        var fileInput = $('#fileUpload')[0]; // Access the DOM element
        var file = fileInput.files[0];

        if (file) {
            validateFile(file);
        }

    });

    let triggerValue = true
    $("#department").change(function () {
        let department = $("#department").val()
        let organizationId = $("#organizationId").val()
        let departmentId = $("#departmentId").val()
        if (organizationId) {
            if (department) {
                let data = {
                    organizationId: organizationId,
                    department: department
                }
                $.ajax({
                    type: "POST",
                    url: addDepartmentsUrl,
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.message || "An error occurred";
                        toastr.error(errorMessage);
                    }
                });
            }
        }
    });

    function resetAddDepartmentForm() {
        $("#addDepartmentOrganizationId").val('').attr("readonly", true).attr("type", "hidden");
        $("#addDepartmentName").val("").removeClass("is-invalid");
        $("#addDepartmentNameError").text("");
    }

    // Validator Method No Special Character Added for Both Update Profile & Add Department Form
    // Add a method to check for special characters
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    });

    // Validation for Update Profile
    // Add validation rules to the form
    $("#editProfileForm").validate({
        rules: {
            firstName: {
                required: true,
                noSpecialChars: true
            },
            lastName: {
                required: true,
                noSpecialChars: true
            },
            organization: {
                required: true,
            },
            department: {
                required: true,
            },
            jobTitle: {
                required: true,
            },
        },
        messages: {
            firstName: {
                required: "First name required",
                noSpecialChars: "Enter the first name with only alphabetic characters"
            },
            lastName: {
                required: "Last name required",
                noSpecialChars: "Enter the last name with only alphabetic characters"
            },
            organization: {
                required: "Organization required",
            },
            department: {
                required: "Department required",
            },
            jobTitle: {
                required: "Job title required",
            },
        },
        errorPlacement: function (error, element) {
            var elementId = element.attr("id");

            $("#" + elementId).addClass("is-invalid");
            // Display the error message in the corresponding error div
            $("#" + elementId + "Error").html(error.text()).show();
        },
        success: function (label, element) {
            // Clear the error message when the field is valid
            $("#" + $(element).attr("id")).removeClass("is-invalid");
            $("#" + element.id + "Error").html("").hide();
        },
        submitHandler: function (form, event) {
            // Check if the file upload error message exists
            const fileUploadError = $("#fileUploadError").text();
            if (fileUploadError) {
                event.preventDefault();
                return;
            }
            // Start the loader
            $.LoadingOverlay("show");
            form.submit();
        }
    });

    // /....... Validation for Update profile


    // Store the original values of the form fields
    let originalFormData = {
        avatar: $("#fileUpload").val(),
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        organizationId: $("#organizationId").val(),
        departmentId: $("#departmentId").val(),
        jobTitle: $("#jobTitle").val(),
    };

    // Function to check if any field has changed to Enable or Disable the Button
    function checkChanges() {
        let currentFormData = {
            avatar: $("#fileUpload").val(),
            firstName: $("#firstName").val(),
            lastName: $("#lastName").val(),
            organizationId: $("#organization").val(),
            departmentId: $("#department").val(),
            jobTitle: $("#jobTitle").val(),
        };
        if (editProfile == true) {
            for (let key in originalFormData) {
                if ((originalFormData[key] !== currentFormData[key]) && (editProfile == true)) {
                    $("#saveChangesBtn").prop("disabled", false).show().removeClass().addClass("btn btn-block btnHeight saveBtnEnable customBorderRadius");
                    return;
                }
            }

            $("#saveChangesBtn").prop("disabled", true).show().removeClass().addClass("btn btn-block btnHeight saveBtnDisable customBorderRadius");
        }
        else {
            return false;
        }
    }

    // Attach event listeners to input and select fields
    $("input, select").on("change keyup", function () {
        checkChanges();
    });

    // /////////////////////////////////////////////////////////////////
    //  Add Department Start here

    // Add Department
    $("#saveDepartmentBtn").click(function (e) {
        let addDepartmentOrganizationId = $("#addDepartmentOrganizationId").val();
        if (addDepartmentOrganizationId == "" || addDepartmentOrganizationId == null || addDepartmentOrganizationId.length == 0) {
            toastr.warning("Organization required");
            e.preventDefault();
            return false;
        }
    });

    // Add a method to check for special characters
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    });

    // Add validation rules to the form => addDepartmentForm
    $("#addDepartmentForm").validate({
        rules: {
            addDepartmentName: {
                required: true,
                maxlength: 255,
                noSpecialChars: false
            },
            // Add rules for other fields here...
        },
        messages: {
            addDepartmentName: {
                required: "Department name required",
                maxlength: "Department name must not exceed 255 characters",
                noSpecialChars: "Enter the department name with only alphabetic characters"
            },
            // Add messages for other fields here...
        },
        errorPlacement: function (error, element) {
            // Display the validation error in the corresponding alert div
            $("#" + $(element).attr("id")).addClass("is-invalid");
            $("#" + element.attr("id") + "Error").html(error.text()).show();
        },
        success: function (label, element) {
            // Clear the error message when the field is valid
            $("#" + $(element).attr("id")).removeClass("is-invalid");
            $("#" + element.id + "Error").html("").hide();
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            // Stop the loader
            $.LoadingOverlay("show");
            addDepartment();
            return;
        }
    });

    // Add New to department to the selected organization
    function addDepartment() {
        let method = $("#addDepartmentForm").attr('method');
        let url = $("#addDepartmentForm").attr('action');

        // Serialize the form data
        let formData = $("#addDepartmentForm").serialize();

        $.ajax({
            type: method,
            url: url,
            data: formData,
            success: function (successResponse) {
                // Stop the loader
                $.LoadingOverlay("hide");
                if (successResponse.response.status == true) {
                    $("#addDepartmentModal").modal("hide");
                    resetAddDepartmentForm();
                    toastr.success(successResponse.response.message);


                    var $departmentSelectBox = $('#departmentId');
                    $departmentSelectBox.empty(); // Clear any existing options
                    $departmentSelectBox.append('<option value="" selected disabled>Select Department</option>'); // Add default option
                    // Populate the select2 box with departments
                    var departments = successResponse.response.departments;

                    $.each(departments, function (index, department) {
                        $departmentSelectBox.append('<option value="' + department.id + '" >' + department.name + '</option>');
                    });

                    // Initialize or refresh select2
                    triggerValue = false;
                    initializeDepartmentSelectBox();
                }

            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");
            }
        });
    }

});
