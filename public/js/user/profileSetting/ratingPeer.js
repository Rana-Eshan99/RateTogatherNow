document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName("btnStyles");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function(button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function() {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function(button) {
                button.style.background = "#007bff"; // Change color to transparent
                button.style.color = "#fff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function() {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function() {
                    // Revert to original transparent style when hover ends
                    button.style.color = "#fff";
                    button.style.backgroundColor = "#007bff";
                    button.style.borderColor = "#007bff";
                });
            });
        }
    });
});
$(document).ready(function () {
    // Send Ajax request on pagination.
    $(document).on('click', '#myPeerRating .pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        // Prepare the data to send (the requestType)
        let data = { requestType: "myPeerRating" };

        // Start the loader
        $.LoadingOverlay("show");

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function (data) {
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#myRatingPeersContentDiv").html('');
                $("#myRatingPeersContentDiv").html(data.html);
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
