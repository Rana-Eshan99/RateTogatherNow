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
    function formatOption(state) {
        if (!state.id || state.id === '-1') {
            return state.text; // Default formatting for the "All Organizations" option
        }

        // Retrieve additional data attributes
        let $optionElement = $(state.element);
        let organizationName = $optionElement.data('name');
        let organizationAddress = $optionElement.data('address');

        // Custom formatting: Bold organization name and regular address
        return $(
            '<span class="truncate-text"><strong>' + organizationName + '</strong><br>' + organizationAddress + '</span>'
        );
    }

    // Initialize the Organization And Department Select box
    $("#organization").select2({
        placeholder: 'All organizations',
        width: '100%', // Adjust width
        templateResult: formatOption, // Use custom formatting function
    });

    $('#organization').on('change', function () {
        var selectedValue = $(this).val();

        // If "Show All Organizations" is selected
        if (selectedValue === "-1") {
            // Reset the organization dropdown to display all options
            $('#organization').val(null).trigger('change');
            // You might want to trigger the search immediately
            sendAjaxRequest();
        } else {
            // Handle normal organization selection
            sendAjaxRequest();
        }
    });

    // Focus on the search box when organization Select2 opens
    $('#organization').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    $("#department").select2({
        placeholder: 'All department',
        width: '100%', // Set the width as per your requirement
    });

    // Focus on the search box when department Select2 opens
    $('#department').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    let debounceTimer; // Declare a timer variable outside of the function
    let previousSearch = ""; // Keep track of the previous search term

    $("#searchPeer").keyup(function (e) {
        // Check for arrow keys or backspace
        if (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 8) {
            // Do not send the request for arrow keys or backspace if the input is already empty
            if ($("#searchPeer").val().trim() === "" && previousSearch === "") {
                return;
            }
        }

        clearTimeout(debounceTimer); // Clear the timer on each keyup event

        debounceTimer = setTimeout(function () {
            let searchPeer = $("#searchPeer").val().trim();

            // If the input is already empty and hasn't changed, don't send the request
            if (searchPeer === "" && previousSearch === "") {
                return;
            }

            // Update previous search term
            previousSearch = searchPeer;

            // Send the request to get data using filter
            sendAjaxRequest();

        }, 500); // Set a delay of 500 milliseconds (or any other value)
    });


    function sendAjaxRequest() {
        let searchPeer = $("#searchPeer").val().trim();
        let organizationId = $("#organization").val();
        let departmentId = $("#department").val();

        // Prepare the data to send (with the applied filter)
        let data = {
            searchPeer: searchPeer,
            organizationId: organizationId,
            departmentId: departmentId,
        };

        // Get the form action (URL) and method
        let action = $("#routeName").val();

        // Start the loader
        $.LoadingOverlay("show");
        // Perform the AJAX request
        $.ajax({
            type: 'GET',
            url: action,
            data: data, // Prepare the data to send (with the applied filter)
            success: function (response) {
                $.LoadingOverlay("hide");
                $("#searchPeer").focus();

                // Update the peer list and count
                $("#peerList").html('');
                $("#peerList").html(response.html);
                $("#peerCount").html(response.peerCount);
            },
            error: function (xhr, status, error) {
                // Stop the loader
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


    // Organization Change Send the ajax request to Search the Peer and load the departments
    $("#organization").change(function (e) {
        let organizationId = $("#organization").val();
        var $departmentSelectBox = $('#department');
        $departmentSelectBox.empty(); // Clear any existing options
        $departmentSelectBox.append('<option value="" selected disabled>Select Department</option>'); // Add default option
        if (organizationId == null || organizationId == "" || organizationId.length == 0) {
            $("#organizationError").html("Organization required").show();
            $("#organization").focus();
        }
        else {
            // Start the loader
            $.LoadingOverlay("show");
            $.ajax({
                type: "GET",
                url: "/department/get-departments/" + organizationId,
                success: function (successResponse) {
                    // Stop the loader
                    $.LoadingOverlay("hide");
                    if (successResponse.response.status == true) {
                        // Populate the select2 box with departments
                        var departments = successResponse.response.departments; // Assuming response.departments contains the list of departments
                        // Populate the select2 box with departments
                        $.each(departments, function (index, department) {
                            $departmentSelectBox.append('<option value="' + department.id + '" >' + department.name + '</option>');
                        });

                        // Initialize or refresh select2
                        $departmentSelectBox.select2({
                            placeholder: 'Select department',
                            width: '100%', // Set the width as per your requirement
                        });
                        sendAjaxRequest();
                        return; // Exit the function
                    }
                },
                error: function (xhr, status, error) {
                    // Stop the loader
                    $.LoadingOverlay("hide");
                    console.log(xhr);
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
        }

    });


    // department Change Send the ajax request to Search the Peer and load the data
    $("#department").change(function (e) {
        let departmentId = $("#department").val();
        if (departmentId == null || departmentId == "" || departmentId.length == 0) {
            $("#departmentError").html("Department required").show();
            $("#department").focus();
        }
        else {
            sendAjaxRequest();
        }

    });

    // Send ajax request on pagination click
    $(document).on('click', '.pagination a', function (e) {
        let searchPeer = $("#searchPeer").val().trim();
        let organizationId = $("#organization").val();
        let departmentId = $("#department").val();

        // Prepare the data to send (with the applied filter)
        let data = {
            searchPeer: searchPeer,
            organizationId: organizationId,
            departmentId: departmentId,
        };

        e.preventDefault();
        var url = $(this).attr('href');
        // Start the loader
        $.LoadingOverlay("show");
        $.ajax({
            url: url,
            type: 'GET',
            data: data, // Prepare the data to send (with the applied filter)
            success: function (data) {
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#peerList").html('');
                $("#peerList").html(data.html);
                $("#peerCount").html(data.peerCount);

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
