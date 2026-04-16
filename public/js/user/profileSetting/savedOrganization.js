$(document).ready(function () {
    let debounceTimerSavedsOrganization; // Declare a timer variable outside of the function
    let previousSearchSavedsOrganization = ""; // Keep track of the previous search term

    $("#searchOrganization").keyup(function (e) {
        e.preventDefault();
        // Check for arrow keys or backspace
        if (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 8) {
            // Do not send the request for arrow keys or backspace if the input is already empty
            if ($("#searchOrganization").val().trim() === "" && previousSearchSavedsOrganization === "") {
                return;
            }
        }

        clearTimeout(debounceTimerSavedsOrganization); // Clear the timer on each keyup event

        debounceTimerSavedsOrganization = setTimeout(function () {
            let searchSavedsOrganization = $("#searchOrganization").val().trim();

            // If the input is already empty and hasn't changed, don't send the request
            if (searchSavedsOrganization === "" && previousSearchSavedsOrganization === "") {
                return;
            }

            // Update previous search term
            previousSearchSavedsOrganization = searchSavedsOrganization;

            if (searchSavedsOrganization === "") {
                // If the input is empty, fetch the whole data set
                $.LoadingOverlay("show");

                let action = $("#routeName").val(); // Get the route name

                // Prepare the data to send (the requestType)
                let data = { requestType: "savedsOrganization" };

                $.ajax({
                    type: 'GET',
                    url: action, // Use the same action URL
                    data: data, // Send an empty data object to indicate "no filter" and send the request type
                    success: function (data) {
                        $.LoadingOverlay("hide");

                        // Update the organization list and count
                        $("#organizationList").html('');
                        $("#organizationList").html(data.html);
                        $("#organizationCount").html(data.organizationCount);
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
                    searchSavedsOrganization: searchSavedsOrganization,
                    requestType: "savedsOrganization"
                };

                // Perform the AJAX request
                $.ajax({
                    type: 'GET',
                    url: action,
                    data: data, // Send only the organization name
                    success: function (data) {
                        $.LoadingOverlay("hide");

                        // Update the organization list and count
                        $("#organizationList").html('');
                        $("#organizationList").html(data.html);
                        $("#organizationCount").html(data.organizationCount);
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


    // Send AJAX request on pagination
    $(document).on('click', '#savedsOrganizationPagination .pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        // Prepare the data to send (including the requestType and searchSavedsOrganization)
        let data = {
            requestType: "savedsOrganization",
            searchSavedsOrganization: $('#searchOrganization').val() // Pass the current search filter
        };

        // Start the loader
        $.LoadingOverlay("show");

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
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


});
