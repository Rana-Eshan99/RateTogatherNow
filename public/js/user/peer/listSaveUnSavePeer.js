$(document).ready(function () {
    let peerSavedStatus = false;
    $('#peerList').on('click', '.savedPeer', function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }
        e.preventDefault();
        let peerId = $(this).data('peer-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to save the peer?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                peerSavedStatus = false;
                $("#savedPeerId_" + peerId).val(peerId);
                $("#savedPeerForm_" + peerId).submit();
            }
        });
    });

    $('#peerList').on('click', '.unSavedPeer', function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }
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
                peerSavedStatus = true;
                $("#savedPeerId_" + peerId).val(peerId);
                $("#savedPeerForm_" + peerId).submit();
            }
        });
    });

    // Bind the form submit event
    $(document).on('submit', "form[id^='savedPeerForm_']", function (event) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }
        event.preventDefault(); // Prevent the default form submission
        // Start the loader
        $.LoadingOverlay("show");

        // Get the form method and action
        let method = $(this).attr('method');
        let action = $(this).attr('action');
        let peerId = $(this).find("input[name='savedPeerId']").val();

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
                    if (peerSavedStatus == true) {
                        $("#savedPeerId_" + peerId).show();
                        $("#unSavedPeerId_" + peerId).hide();
                    }
                    else {
                        $("#savedPeerId_" + peerId).hide();
                        $("#unSavedPeerId_" + peerId).show();
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
