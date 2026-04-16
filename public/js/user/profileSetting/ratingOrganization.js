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
    let debounceTimerOrganizationRating; // Declare a timer variable outside of the function
    let previousSearchOrganizationRating = ""; // Keep track of the previous search term
    let myRatingType = "";
    $("#searchMyOrganizationRating").keyup(function (e) {
        e.preventDefault();
        // Check which tab is active
        if ($("#myRatingPeersTab").hasClass("active")) {
            myRatingType = "myPeerRating";
            // Add logic specific to the "My Rating-Peers" tab
        } else if ($("#myRatingOrganizationsTab").hasClass("active")) {
            myRatingType = "myOrganizationRating";
            // Add logic specific to the "My Rating-Organizations" tab
        }
        else {
            myRatingType = "";
            toastr.error("Invalid Request Type");
            return;
        }

        // Check for arrow keys or backspace
        if (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 8) {
            // Do not send the request for arrow keys or backspace if the input is already empty
            if ($("#searchMyOrganizationRating").val().trim() === "" && previousSearchOrganizationRating === "") {
                return;
            }
        }

        clearTimeout(debounceTimerOrganizationRating); // Clear the timer on each keyup event

        debounceTimerOrganizationRating = setTimeout(function () {
            let searchMyOrganizationRating = $("#searchMyOrganizationRating").val().trim();

            // If the input is already empty and hasn't changed, don't send the request
            if (searchMyOrganizationRating === "" && previousSearchOrganizationRating === "") {
                return;
            }

            // Update previous search term
            previousSearchOrganizationRating = searchMyOrganizationRating;

            if (searchMyOrganizationRating === "") {
                // If the input is empty, fetch the whole data set
                $.LoadingOverlay("show");

                let action = $("#routeName").val(); // Get the route name

                // Prepare the data to send (the requestType)
                let data = { requestType: myRatingType };

                $.ajax({
                    type: 'GET',
                    url: action, // Use the same action URL
                    data: data, // Send an empty data object to indicate "no filter" and send the request type
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if (myRatingType == "myPeerRating") {
                            // Update the peer list and count
                            $("#myRatingPeersContentDiv").html('');
                            $("#myRatingPeersContentDiv").html(response.html);
                        }
                        else if (myRatingType == "myOrganizationRating") {
                            // Update the organization list and count
                            $("#myRatingOrganizationsContentDiv").html('');
                            $("#myRatingOrganizationsContentDiv").html(response.html);
                        }
                    },
                    error: function (xhr, status, error) {
                        $.LoadingOverlay("hide");
                        console.log(error);
                        toastr.error("Failed to fetch data");
                    }
                });

            } else {
                // Start the loader for filtered results
                $.LoadingOverlay("show");

                // Get the form action (URL) and method
                let action = $("#routeName").val();

                // Prepare the data to send the organization name & requestType
                let data = {
                    searchMyOrganizationRating: searchMyOrganizationRating,
                    requestType: myRatingType,
                };

                // Perform the AJAX request
                $.ajax({
                    type: 'GET',
                    url: action,
                    data: data, // Send only the organization name
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        if (myRatingType == "myPeerRating") {
                            // Update the peer list and count
                            $("#myRatingPeersContentDiv").html('');
                            $("#myRatingPeersContentDiv").html(response.html);
                        }
                        else if (myRatingType == "myOrganizationRating") {
                            // Update the organization list and count
                            $("#myRatingOrganizationsContentDiv").html('');
                            $("#myRatingOrganizationsContentDiv").html(response.html);
                        }
                    },
                    error: function (xhr, status, error) {
                        $.LoadingOverlay("hide");
                        console.log(error);

                        // Handle error
                        if (xhr.state.status == 400 || xhr.state.status == 500) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error(xhr.responseJSON.response.message);
                        }
                    }
                });
            }

        }, 500); // Set a delay of 500 milliseconds (or any other value)
    });


    // Send Ajax call on pagination
    $(document).on('click', '#myOrganizationRating .pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        // Prepare the data to send (the requestType)
        let data = { requestType: "myOrganizationRating" };


        // Start the loader
        $.LoadingOverlay("show");

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function (data) {
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#myRatingOrganizationsContentDiv").html('');
                $("#myRatingOrganizationsContentDiv").html(data.html);
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
