$(document).ready(function () {
    let organizationSavedStatus = false;
    $('#organizationList').on('click', '.savedOrganization', function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this organization.");
            e.preventDefault();
            return false
        }
        e.preventDefault();
        let organizationId = $(this).data('organization-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to save the organization?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                organizationSavedStatus = false;
                $("#organizationIdSaved_" + organizationId).val(organizationId);
                $("#savedOrganizationForm_" + organizationId).submit();
            }
        });
    });

    $('#organizationList').on('click', '.unSavedOrganization', function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this organization.");
            e.preventDefault();
            return false
        }
        e.preventDefault();
        let organizationId = $(this).data('organization-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to remove this organization from your saved list?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'orange',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                organizationSavedStatus = true;
                $("#organizationIdSaved_" + organizationId).val(organizationId);
                $("#savedOrganizationForm_" + organizationId).submit();
            }
        });
    });

    // Bind the form submit event
    $(document).on('submit', "form[id^='savedOrganizationForm_']", function (event) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this organization.");
            e.preventDefault();
            return false
        }
        event.preventDefault(); // Prevent the default form submission
        // Start the loader
        $.LoadingOverlay("show");

        // Get the form method and action
        let method = $(this).attr('method');
        let action = $(this).attr('action');
        let organizationId = $(this).find("input[name='savedOrganizationId']").val();

        // Serialize the form data
        let formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            type: method,
            url: action,
            data: formData,
            success: function (responseSuccess) {
                // Stop the loader
                $.LoadingOverlay("hide");
                // Handle successful response
                if (responseSuccess.response.status == true) {
                    toastr.success(responseSuccess.response.message)
                    if (organizationSavedStatus == true) {
                        ;
                        $("#savedOrganization_" + organizationId).show();
                        $("#unSavedOrganization_" + organizationId).hide();
                    }
                    else {
                        $("#savedOrganization_" + organizationId).hide();
                        $("#unSavedOrganization_" + organizationId).show();
                    }
                }
            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");
                console.log(error);
                // Handle error
                if (xhr.state.status == 400 || xhr.state.status == 500) {
                    toastr.error(xhr.responseJSON.message);
                }
                else {
                    toastr.error(xhr.responseJSON.response.message);
                }
                return false;
            }
        });
    });
});
