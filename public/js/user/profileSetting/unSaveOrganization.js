$(document).ready(function () {
    $('#organizationList').on('click', '.unSavedOrganization', function (e) {
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
                $("#organizationIdSaved_" + organizationId).val(organizationId);
                $("#savedOrganizationForm_" + organizationId).submit();
            }
            else{
                e.preventDefault();
            }
        });
    });

    // Bind the form submit event
    $(document).on('submit', "form[id^='savedOrganizationForm_']", function (event) {
        event.preventDefault(); // Prevent the default form submission
        // Start the loader
        $.LoadingOverlay("show");

        // Get the form method and action
        let method = $(this).attr('method');
        let action = $(this).attr('action');
        let searchSavedOrganizationFilter = $("#searchOrganization").val();

        // Serialize the form data
        let formData = $(this).serialize();

        // Append searchSavedOrganizationFilter to the serialized form data
        formData += `&searchSavedOrganizationFilter=${encodeURIComponent(searchSavedOrganizationFilter)}`;

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

                    $("#organizationList").html('');
                    $("#organizationList").html(responseSuccess.response.html);
                    $("#organizationCount").html(responseSuccess.response.organizationCount);
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
