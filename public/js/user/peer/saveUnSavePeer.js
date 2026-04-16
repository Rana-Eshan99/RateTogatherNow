$(document).ready(function () {
    let peerSavedStatus = false;
    $("#unSavedPeer").click(function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }else{
            e.preventDefault();
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
                    $("#savedPeerForm").submit();
                }
            });
        }
    });


    $("#savedPeer").click(function (e) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }
        else{
            e.preventDefault();
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
                    $("#savedPeerForm").submit();
                }
            });
        }
    });


    // Bind the form submit event
    $("#savedPeerForm").submit(function (event) {
        if(userLoggedIn == 'false'){
            toastr.info("Sorry, you are not logged in. Please login to save this peer.");
            e.preventDefault();
            return false
        }
        // Start the loader
        $.LoadingOverlay("show");
        event.preventDefault(); // Prevent the default form submission

        // Get the form method and action
        let method = $(this).attr('method');
        let action = $(this).attr('action');

        // Serialize the form data
        let formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            type: method,
            url: action,
            data: formData,
            success: function (responseSuccess) {
                // Handle successful response
                // Stop the loader
                $.LoadingOverlay("hide");
                if (responseSuccess.response.status == true) {
                    toastr.success(responseSuccess.response.message);
                    if (peerSavedStatus == false) {
                        $("#savedPeer").show();
                        $("#unSavedPeer").hide();
                    }
                    else {
                        $("#savedPeer").hide();
                        $("#unSavedPeer").show();
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
