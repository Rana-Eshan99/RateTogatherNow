$(document).ready(function () {
    let debounceTimerSavedsPeer; // Declare a timer variable outside of the function
    let previousSearchSavedsPeer = ""; // Keep track of the previous search term

    $("#searchSavedPeer").keyup(function (e) {
        e.preventDefault();
        // Check for arrow keys or backspace
        if (e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39 || e.keyCode === 40 || e.keyCode === 8) {
            // Do not send the request for arrow keys or backspace if the input is already empty
            if ($("#searchSavedPeer").val().trim() === "" && previousSearchSavedsPeer === "") {
                return;
            }
        }

        clearTimeout(debounceTimerSavedsPeer); // Clear the timer on each keyup event

        debounceTimerSavedsPeer = setTimeout(function () {
            let searchSavedPeer = $("#searchSavedPeer").val().trim();

            // If the input is already empty and hasn't changed, don't send the request
            if (searchSavedPeer === "" && previousSearchSavedsPeer === "") {
                return;
            }

            // Update previous search term
            previousSearchSavedsPeer = searchSavedPeer;

            if (searchSavedPeer === "") {
                // If the input is empty, fetch the whole data set
                $.LoadingOverlay("show");

                let action = $("#routeName").val(); // Get the route name

                // Prepare the data to send (the requestType)
                let data = { requestType: "savedsPeer" };

                $.ajax({
                    type: 'GET',
                    url: action, // Use the same action URL
                    data: data, // Send an empty data object to indicate "no filter" and send the request type
                    success: function (data) {
                        $.LoadingOverlay("hide");

                        // Update the organization list and count
                        $("#savedPeerList").html('');
                        $("#savedPeerList").html(data.html);
                        $("#savedPeerCount").html(data.savedPeerCount);
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
                let action = $("#routeNameSavedPeer").val();

                // Prepare the data to send the peer name & requestType
                let data = {
                    searchSavedPeer: searchSavedPeer,
                    requestType: "savedsPeer"
                };

                // Perform the AJAX request
                $.ajax({
                    type: 'GET',
                    url: action,
                    data: data, // Send only the organization name
                    success: function (data) {
                        $.LoadingOverlay("hide");

                        // Update the organization list and count
                        $("#savedPeerList").html('');
                        $("#savedPeerList").html(data.html);
                        $("#savedPeerCount").html(data.savedPeerCount);
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


    // Send Ajax request on pagination
    $(document).on('click', '#savedsPeerPagination .pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        // Prepare the data to send (including the requestType and searchSavedPeer)
        let data = {
            requestType: "savedsPeer",
            searchSavedPeer: $('#searchSavedPeer').val() // Pass the current search filter
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

                $("#savedPeerList").html('');
                $("#savedPeerList").html(data.html);
                $("#savedPeerCount").html(data.savedPeerCount);
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
