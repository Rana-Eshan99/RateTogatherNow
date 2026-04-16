document.addEventListener("DOMContentLoaded", function () {
    var buttons = document.getElementsByClassName("btnStyles");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function (button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function () {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function (button) {
                button.style.background = "#007bff"; // Change color to transparent
                button.style.color = "#fff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function () {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function () {
                    // Revert to original transparent style when hover ends
                    button.style.color = "#fff";
                    button.style.backgroundColor = "#007bff";
                    button.style.borderColor = "#007bff";
                });
            });
        }
    });
});


function initializeDepartmentSelectBox() {
    // Custom matcher function to always show "Add Department" option
    function customMatcher(params, data) {
        // Always display "Add Department" option
        if (data.id === 'addDepartment') {
            return data;
        }

        // Default behavior for other options
        return $.fn.select2.defaults.defaults.matcher(params, data);
    }

    // Initialize the department select box with Select2
    $(".departmentSelectBox").select2({
        placeholder: 'Select department',
        width: '100%', // Set the width as per your requirement
        matcher: customMatcher, // Apply custom matcher
        templateResult: function (state) {
            if (!state.id) {
                return state.text;
            }

            var $state = $('<span>' + state.text + '</span>');

            // Check if the option is "Add Department"
            if (state.id === 'addDepartment') {
                // Create a custom HTML element for "Add Department"
                $state = $(
                    '<div><i class="fas fa-plus" style="margin-right: 10px; height:24px; width:24px;"></i>' + state.text + '</div>'
                ).css({

                    'font-size': '16px',
                    'font-weight': '500',
                    'background-color': 'transparent'  // Avoid Select2 default selection behavior
                });

            }

            return $state;
        },
        templateSelection: function (state) {
            return state.text;  // Keeps selected text default without custom styles
        }
    });

    // Append the "Add Department" option if it doesn’t exist
    var newOption = new Option('Add Department', 'addDepartment', false, false);
    if ($(".departmentSelectBox option[value='addDepartment']").length === 0) {
        $(".departmentSelectBox").append(newOption).trigger('change');
    }

    // Listen for changes on the department select box to open modal if "Add Department" is selected
    $(".departmentSelectBox").on('change', function () {
        let organizationId = $("#organizationId").val();

        if (this.value === 'addDepartment' && organizationId) {
            // Open the modal
            $('#addDepartmentModal').modal('show');

            // Reset the selection
            $(this).val(null).trigger('change');

            // Set the organization ID
            $("#addDepartmentOrganizationId").val(organizationId);
        }
    });

}

// Initialize the department select box and organization select box
$(document).ready(function () {
    function formatOption(state) {
        // Format the "Add New Organization" option
        if (state.id === 'addNewOrganization') {
            return $(
                '<i class="fas fa-plus" style="margin-right: 7px; height:24px; width:24px;"></i><strong>' +
                state.text +
                '</strong>'
            );
        }

        // Format other options: Bold organization name and address
        if (state.text.includes(' - ')) {
            let organizationName = state.text.split(' - ')[0];
            let organizationAddress = state.text.split(' - ')[1];
            return $(
                '<span class="truncate-text"><strong>' +
                organizationName +
                '</strong> - ' +
                organizationAddress +
                '</span>'
            );
        }
        return state.text; // Default fallback
    }

    // Custom matcher to always show "Add New Organization"
    function customMatcher(params, data) {
        // Always display "Add New Organization" option
        if (data.id === 'addNewOrganization') {
            return data;
        }

        // Default behavior for other options
        return $.fn.select2.defaults.defaults.matcher(params, data);
    }

    // Initialize the Select2 with the custom matcher
    $("#organizationId").select2({
        placeholder: 'Enter Organization Name',
        width: '100%',
        templateResult: formatOption,
        matcher: customMatcher, // Use the custom matcher
    });

    // Focus on the search box when the Select2 dropdown opens
    $('#organizationId').on('select2:open', function () {
        document.querySelector('.select2-search__field').focus();
    });

    // Initialize department select box
    initializeDepartmentSelectBox();

    // Focus on the search box when departmentId Select2 opens
    $('#departmentId').on('select2:open', function () {
        document.querySelector('.select2-search__field').focus();
    });
});


$(document).ready(function () {


    let resetOrganization = false;
    $("#btnCancel").click(function (e) {
        e.preventDefault();
        // Cancel the adding peer process and redirect back to the list Url
        window.location.href = redirectBackUrl;
    });


    $("#organizationId").change(function (e) {
        if (resetOrganization === true) {
            resetOrganization = false;
            return false;
        }

        let organizationId = $("#organizationId").val();
        var departmentSelectBox = $("#departmentId");

        // Clear previous errors and styling
        $("#organizationIdError").html("").hide();
        $("#organizationId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
        $("#departmentId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");

        // Clear existing options and add default option
        departmentSelectBox.empty();
        departmentSelectBox.append('<option value="" selected disabled>Enter Department</option>');

        if (!organizationId) {
            $("#organizationIdError").html("Organization required.").show();
            $("#organizationId").focus();
            return false;
        }

        if (organizationId === "addNewOrganization") {
            // Prevent AJAX request if "Add New Organization" is selected
            return false;
        }

        // Start the loader
        $.LoadingOverlay("show");

        // Perform AJAX request
        $.ajax({
            type: "GET",
            url: "/department/get-departments/" + organizationId,
            success: function (successResponse) {
                // Stop the loader
                $.LoadingOverlay("hide");

                if (successResponse.response.status === true) {
                    var departments = successResponse.response.departments;

                    if (departments.length > 0) {
                        // Populate department select box
                        $.each(departments, function (index, department) {
                            departmentSelectBox.append('<option value="' + department.id + '">' + department.name + '</option>');
                        });
                    }
                    // Initialize or refresh select2
                    initializeDepartmentSelectBox();
                }
            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");

                // Handle error
                if (xhr.status === 400 || xhr.status === 500) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error(xhr.responseJSON.response.message);
                }
            }
        });
    });



    // Submit the form here
    // Add a method to check for special characters
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    });
    // Add validation rules to the form
    $("#addPeerForm").validate({
        rules: {
            firstName: {
                required: true,
                maxlength: 255,
                noSpecialChars: true
            },
            lastName: {
                required: true,
                maxlength: 255,
                noSpecialChars: true
            },
            gender: {
                required: true,
            },
            ethnicity: {
                required: true,
            },
            organizationId: {
                required: true,
            },
            departmentId: {
                required: true,
            },
            jobTitle: {
                required: true,
                noSpecialChars: true
            },
            // Add rules for other fields here...
        },
        messages: {
            firstName: {
                required: "First name required.",
                maxlength: "First name must not exceed 255 characters.",
                noSpecialChars: "Enter the first name with only alphabetic characters."
            },
            lastName: {
                required: "Last name required.",
                maxlength: "Last name must not exceed 255 characters.",
                noSpecialChars: "Enter the last name with only alphabetic characters."
            },
            gender: {
                required: "Gender required.",
            },
            ethnicity: {
                required: "Ethnicity required.",
                maxlength: "Ethnicity must not exceed 255 characters.",
            },
            organizationId: {
                required: "Organization required.",
            },
            departmentId: {
                required: "Department required.",
            },
            jobTitle: {
                required: "Job title required.",
                maxlength: "Job title name must not exceed 255 characters.",
            },
            // Add messages for other fields here...
        },
        errorPlacement: function (error, element) {
            var elementId = element.attr("id");

            // Check if the element is one of the fields that should not have an icon (e.g., gender, ethnicity, etc.)
            if (elementId === "gender" || elementId === "ethnicity") {
                // Add custom class for border-only error styling
                $("#" + elementId).addClass("is-invalid-border-only");
            }
            else if (elementId === "organizationId") {
                // Add custom class for Select2 to display red border
                $("#organizationId").next('.select2-container').find('.select2-selection').addClass('is-invalid-border-only');
            }
            else if (elementId === "departmentId") {
                // Add custom class for Select2 to display red border at departmentId
                $("#departmentId").next('.select2-container').find('.select2-selection').addClass('is-invalid-border-only');
            }
            else {
                // For other fields, add the regular 'is-invalid' class
                $("#" + elementId).addClass("is-invalid");
            }

            // Display the error message in the corresponding error div
            $("#" + elementId + "Error").html(error.text()).show();
        },
        success: function (label, element) {
            var elementId = element.id;

            // Remove the appropriate invalid class when the field is valid
            if (elementId === "gender" || elementId === "ethnicity") {
                $("#" + elementId).removeClass("is-invalid-border-only");
            }
            else if (elementId === "organizationId") {
                // Remove custom class for Select2 to display red border at organizationId
                $("#organizationId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
            }
            else if (elementId === "departmentId") {
                // Remove custom class for Select2 to display red border at departmentId
                $("#departmentId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
            }
            else {
                $("#" + elementId).removeClass("is-invalid");
            }

            // Clear the error message
            $("#" + elementId + "Error").html("").hide();
        },
        submitHandler: function (form, event) {
            // Start the loader
            $.LoadingOverlay("show");
            // Form is valid, you can submit it here
            form.submit();
        }
    });

    // Trigger validation on stateId change
    $("#departmentId").change(function () {
        let organizationId = $("#organizationId").val();
        let departmentId = $(this).val();

        // Check if the organization ID is empty
        if (!organizationId) {
            // Add custom class for Select2 to display red border at organizationId
            $("#organizationId").next('.select2-container').find('.select2-selection').addClass("is-invalid-border-only");
            $("#organizationIdError").text("Organization required").show();
        } else {
            // Remove validation error for organizationId if previously shown
            $("#organizationId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
            $("#organizationIdError").text("").hide();

            // Proceed with department ID check
            if (departmentId === "addDepartment") {
                // Reset the select box and open the add department modal
                $(this).val(null).trigger('change');
                resetAddDepartmentForm();
                $("#addDepartmentOrganizationId").val(organizationId);
                $("#addDepartmentModal").modal("show");
            } else {
                // Remove custom class if department ID is valid
                $(this).next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
                $("#departmentIdError").text("").hide();
            }
        }
    });


    function resetAddDepartmentForm() {
        $("#addDepartmentOrganizationId").val('').attr("readonly", true).attr("type", "hidden");
        $("#department").val("").removeClass("is-invalid");
        $("#addDepartmentNameError").text("");
    }


    // After Adding New Peer it will show the Success Modal
    if (sessionAddPeer == "true") {
        // Show Modal
        $('#alertModal').modal('show');

        $('#btnClose').click(function () {
            $("#alertModal").modal('hide');
            sessionAddPeer = "false";
            window.location.href = redirectBackUrl;
        });
    }


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
            department: {
                required: true,
                maxlength: 255,
                noSpecialChars: false
            },
            // Add rules for other fields here...
        },
        messages: {
            department: {
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
                console.log(error);
                // Handle error
                if ((xhr.state.status == 400) || (xhr.state.status == 500)) {
                    toastr.error(xhr.responseJSON.message);
                }
                else if (xhr.status == 422) {
                    // Validation error handling
                    var errors = xhr.responseJSON.errors;

                    // Loop through errors and display them below the relevant fields
                    $.each(errors, function (field, messages) {
                        // Use the field name to construct the ID of the error message element
                        var errorField = $("#" + field);
                        var errorMessage = $("#" + field + "Error");

                        if (errorField.length && errorMessage.length) {
                            // Set the error message text and show it
                            errorField.addClass('is-invalid');
                            errorMessage.text(messages[0]).show();
                        }
                    });

                    toastr.error(xhr.responseJSON.message);
                }
                else {
                    toastr.error(xhr.responseJSON.response.message);
                }
                return false;
            }
        });
    }


});
