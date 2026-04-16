$(document).ready(function () {
    $('#savedPeerList').on('click', '.unSavedPeer', function (e) {
        e.preventDefault();
        let peerId = $(this).data('peer-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to remove this Peer from your saved list?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'orange',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#savedPeerForm_" + peerId).submit();
            }
            else{
                e.preventDefault();
            }
        });
    });

    // Bind the form submit event
    $(document).on('submit', "form[id^='savedPeerForm_']", function (event) {
        event.preventDefault(); // Prevent the default form submission
        // Start the loader
        $.LoadingOverlay("show");

        // Get the form method and action
        let method = $(this).attr('method');
        let action = $(this).attr('action');
        let searchSavedPeerFilter = $("#searchSavedPeer").val();

        // Serialize the form data
        let formData = $(this).serialize();

        // Append searchSavedPeerFilter to the serialized form data
        formData += `&searchSavedPeerFilter=${encodeURIComponent(searchSavedPeerFilter)}`;

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

                    $("#savedPeerList").html('');
                    $("#savedPeerList").html(responseSuccess.response.html);
                    $("#savedPeerCount").html(responseSuccess.response.savedPeerCount);

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
