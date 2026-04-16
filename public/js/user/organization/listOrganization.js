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
    let debounceTimer; // Declare a timer variable outside of the function
    let previousSearch = ""; // Keep track of the previous search term

    $("#searchOrganization").keyup(function (e) {
        // Check for arrow keys or backspace
        if (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 8) {
            // Do not send the request for arrow keys or backspace if the input is already empty
            if ($("#searchOrganization").val().trim() === "" && previousSearch === "") {
                return;
            }
        }

        clearTimeout(debounceTimer); // Clear the timer on each keyup event

        debounceTimer = setTimeout(function () {
            let searchOrganization = $("#searchOrganization").val().trim();

            // If the input is already empty and hasn't changed, don't send the request
            if (searchOrganization === "" && previousSearch === "") {
                return;
            }

            // Update previous search term
            previousSearch = searchOrganization;

            if (searchOrganization === "") {
                // If the input is empty, fetch the whole data set
                $.LoadingOverlay("show");

                let action = $("#routeName").val(); // Get the route name

                $.ajax({
                    type: 'GET',
                    url: action, // Use the same action URL
                    data: {}, // Send an empty data object to indicate "no filter"
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        $("#organizationList").html(response.html);
                        $("#organizationCount").html(response.organizationCount);
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

                // Prepare the data to send (only the organization name)
                let data = { searchOrganization: searchOrganization };

                // Perform the AJAX request
                $.ajax({
                    type: 'GET',
                    url: action,
                    data: data, // Send only the organization name
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        $("#searchOrganization").focus();

                        // Update the organization list and count
                        $("#organizationList").html(response.html);
                        $("#organizationCount").html(response.organizationCount);
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

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        // Start the loader
        $.LoadingOverlay("show");
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#organizationList").html('');
                $("#organizationList").html(data.html);
                $("#organizationCount").html(data.organizationCount);
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

    function getVisitorId() {
        let storedVisitorId = localStorage.getItem('visitorId');

        if (storedVisitorId) {
            document.getElementById('visitorId').value = storedVisitorId;
            return Promise.resolve(storedVisitorId);
        } else {
            return FingerprintJS.load()
                .then(fp => fp.get())
                .then(result => {
                    const visitorId = result.visitorId;
                    localStorage.setItem('visitorId', visitorId);

                    const visitorIdElement = document.getElementById('visitorId');
                    if (visitorIdElement) {
                        visitorIdElement.value = visitorId;
                    }

                    return visitorId;
                });
        }
    }

    getVisitorId().then(function(visitorId) {
        // Prepare the form data for AJAX submission
        var formData = {
            visitorId: visitorId,  // Include visitor ID here
        };
        $.ajax({
            url: '/organization/list',
            type: 'GET',

            data: formData,
            success: function (response) {

            },
            error: function (xhr) {

            }
        });
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(sendPositionToServer, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function sendPositionToServer(position) {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;


        getVisitorId().then(function(visitorId) {
            // Prepare the form data for AJAX submission
            var formData = {
                visitorId: visitorId,  // Include visitor ID here
                latitude: latitude,
                longitude: longitude
            };
            
            $.ajax({
                url: '/save-location',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                },
                error: function (xhr) {
                    console.log('Error adding location');
                }
            });
        });

    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                toastr.info("You have not allowed access to your current location, which may cause issues when trying to view nearby organizations and their peers.");
                break;
            case error.POSITION_UNAVAILABLE:
                toastr.info("Location information is unavailable. Chose an other broswer");
                break;
            case error.TIMEOUT:
                toastr.info("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                toastr.info("An unknown error occurred.");
                break;
        }
    }
    // Call getLocation on page load
    window.onload = getLocation();

});
