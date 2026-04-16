$(document).ready(function () {

    function validateFile(file) {
        var validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        var maxSize = 1 * 15360 * 1024; // 15MB
        var fileUploadError = document.getElementById('fileUploadError');

        if (!validTypes.includes(file.type)) {
            fileUploadError.textContent = 'Invalid file type. Only SVG, PNG, JPG, and GIF are allowed.';
            return false;
        }

        if (file.size > maxSize) {
            fileUploadError.textContent = 'File size exceeds 15MB.';
            return false;
        }

        fileUploadError.textContent = ''; // Clear previous error message
        return true;
    }

    $('#btnCompleteProfile').click(function (e) {
        var fileInput = $('#fileUpload')[0]; // Access the DOM element
        var file = fileInput.files[0];

        if (file) {
            $("#profilePicture").attr('src', defaultAvatar);
            $(".firstDiv").css('height', '100%');
        }
        else {
            var fileType = file.type;
            var fileSize = file.size;
            var allowedTypes = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'];
            var maxSize = 1 * 15360 * 1024; // 15MB in bytes

            if ($.inArray(fileType, allowedTypes) === -1) {
                $('#fileUploadError').text('Invalid file type. Only SVG, PNG, JPG, or GIF files are allowed.');
                fileInput.value = ''; // Clear the input
            }
            else {
                if (fileSize > maxSize) {
                    $('#fileUploadError').text('File size exceeds 15MB. Please upload a smaller file.');
                    fileInput.value = ''; // Clear the input
                }
                else {
                    $('#fileUploadError').text(''); // Clear any previous error messages
                }
            }

        }

    });


    // Show Profile avatar on file change and check it's properties
    $('#fileUpload').on('change', function () {
        const fileInput = $('#fileUpload')[0];
        const file = fileInput.files[0];
        const errorMessage = $('#fileUploadError');
        const profilePicture = $('#profilePicture');
        const previewPicture = $('#previewPicture');

        if (file) {
            const validTypes = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'];
            const maxSize = 1 * 15360 * 1024; // 15MB in bytes

            if (validTypes.includes(file.type) && file.size <= maxSize) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profilePicture.attr('src', e.target.result);
                    previewPicture.attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
                errorMessage.hide();
            } else {
                profilePicture.attr('src', "");
                previewPicture.attr('src', "");
                $("#profilePicture").attr('src', defaultAvatar);
                $(".firstDiv").css('height', 'auto');
                errorMessage.show();
            }
        } else {
            $("#profilePicture").attr('src', defaultAvatar);
            $(".firstDiv").css('height', 'auto');
            errorMessage.show();
        }
    });

    $.validator.addMethod("filesize", function (value, element) {
        if (element.files.length === 0) return false; // No file selected

        const file = element.files[0];
        const maxSize = 1 * 15360 * 1024; // 15MB in bytes
        return file.size <= maxSize;
    }, "File size must be less than 15MB.");


    // Custom validator for file type and size
    $.validator.addMethod("filetype", function (value, element) {
        if (element.files.length === 0) return false; // No file selected

        const file = element.files[0];
        const validTypes = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'];
        return validTypes.includes(file.type);
    }, "Please upload an SVG, PNG, JPG, or GIF file.");


    // Add a method to check for special characters
    $.validator.addMethod("noSpecialChars", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
    });

    // Add validation rules to the form
    $("#completeSignUpForm").validate({
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
            organization: {
                required: true,
            },
            department: {
                required: true,
            },
            jobTitle: {
                required: true,
                maxlength: 255
            },
            fileUpload: {
                filetype: true,
                filesize: true
            },

        },
        messages: {
            firstName: {
                required: "First name required",
                maxlength: "First name must not exceed 255 characters",
                noSpecialChars: "Enter the first name with only alphabetic characters"
            },
            lastName: {
                required: "Last name required",
                maxlength: "Last name must not exceed 255 characters",
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
                maxlength: "Job title must not exceed 255 characters"
            },
            fileUpload: {
                filetype: "Please upload an SVG, PNG, JPG, or GIF file",
                filesize: "File size must be less than 15MB"
            },
        }, errorPlacement: function (error, element) {
            var elementId = element.attr("id");

            $("#" + elementId).addClass("is-invalid");

            $(".firstDiv").css('height', 'auto');
            // Display the error message in the corresponding error div
            $("#" + elementId + "Error").html(error.text()).show();
        },
        success: function (label, element) {
            var elementId = element.id;

            $("#" + elementId).removeClass("is-invalid");

            // Clear the error message
            $("#" + elementId + "Error").html("").hide();
            // Check if there are no more errors
            if ($(".is-invalid").length === 0 && $(".is-invalid-border-only").length === 0) {
                $(".firstDiv").css('height', '100vh'); // Set height to 100vh if no errors left
            }
        },
        submitHandler: function (form, event) {
            // Check if the file upload error message exists
            const fileUploadError = $("#fileUploadError").text();
            if (fileUploadError) {
                event.preventDefault();
                return;
            }
            // Disable the submit button
            const $submitButton = $("#btnCompleteProfile");
            $submitButton.attr('disabled', true).text('Processing...');

            // Form is valid, you can submit it here
            $("#userEmail").val(userEmail);
            $("#googleId").val(googleId);
            $("#appleId").val(appleId);
            form.submit();
        }
    });


    $("#department").change(function () {
        let departmentId = $("#department").val()
        if (departmentId == "" || departmentId == null || departmentId.length == 0) {
            // Remove custom class for Select2 to display red border at department
            $("#department").next('.select2-container').find('.select2-selection').addClass("is-invalid-border-only");
            $("#departmentError").text("Department required").show();
        }
        else {
            // Remove custom class for Select2 to display red border at department
            $("#department").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
            $("#departmentError").text("").hide();
        }
    });


    $(document).ready(function () {
        // Map organizations data to format required by jQuery UI Autocomplete
        const organizationSuggestions = organizations.map(org => ({
            label: org.name,
            value: org.id
        }));

        let isOrganizationSelected = false;

        $('#organization').autocomplete({
            minLength: 0, // Allows the autocomplete to show on focus without typing
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
                $('#department').val('').autocomplete({ source: [] });
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
                $('#department').val('').autocomplete({ source: [] });
                $('#departmentId').val('');
            } else {
                // If modified manually, clear the organizationId and reset department fields
                $('#organizationId').val('');
                $('#department').val('').autocomplete({ source: [] });
                $('#departmentId').val('');
            }
        });

        // Function to send AJAX request for department suggestions
        function sendDepartmentAjaxRequest(organizationId) {
            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                url: `department/get-departments/${organizationId}`,
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
                                minLength: 0, // Allows the autocomplete to show on focus without typing
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
                            $('#department').autocomplete({ source: [] });
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
    });

});
