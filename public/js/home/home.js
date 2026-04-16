$(document).ready(function () {
    function applyCharacterLimit() {
        const inputField = document.getElementById('search-organizations');
        const placeholderText = inputField.getAttribute('placeholder');
        // Apply the limit only if the screen size is 374px or smaller
        if (window.innerWidth == 344) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 7));
        }
        else if (window.innerWidth == 430) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 29));
        }
        else if (window.innerWidth == 412) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 19));
        }
        else if (window.innerWidth == 360) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 7));
        }
        else if (window.innerWidth < 539) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 19));
        }
        else if (window.innerWidth == 820) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 19));
        }
        else if (window.innerWidth == 853) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 11));
        }
        else if (window.innerWidth == 912) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 19));
        }

        else {
            inputField.setAttribute('placeholder', placeholderText); // Reset to original if larger
        }
    }

    // Function to truncate text
    function truncateText(text, limit) {
        if (text.length > limit) {
            return text.substring(0, limit) + '...';
        }
        return text;
    }

    // Apply the limit on window resize or load
    window.addEventListener('resize', applyCharacterLimit);
    window.addEventListener('load', applyCharacterLimit);

    function applyCharacterLimitPeer() {
        const inputField = document.getElementById('search-peers');
        const placeholderText = inputField.getAttribute('placeholder');
        // Apply the limit only if the screen size is 374px or smaller
        if (window.innerWidth == 344) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 7));
        }
        else if (window.innerWidth == 430) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 29));
        }
        else if (window.innerWidth == 412) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 25));
        }
        else if (window.innerWidth == 360) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 7));
        }
        else if (window.innerWidth < 539) {
            inputField.setAttribute('placeholder', truncateText(placeholderText, 19));
        }
        else {
            inputField.setAttribute('placeholder', placeholderText); // Reset to original if larger
        }
    }

    // Function to truncate text
    function truncateText(text, limit) {
        if (text.length > limit) {
            return text.substring(0, limit) + '...';
        }
        return text;
    }

    // Apply the limit on window resize or load
    window.addEventListener('resize', applyCharacterLimitPeer);
    window.addEventListener('load', applyCharacterLimitPeer);

    // When the Organizations tab is clicked
    $('#nav-organizations-tab').on('click', function () {
        // Clear the Peers search and results
        $('#search-peers').val(''); // Clear the search input
        $('#peer-results').empty();  // Clear the search results
        $('#peer-results-container').remove();
    });

    // When the Peers tab is clicked
    $('#nav-peers-tab').on('click', function () {
        // Clear the Organizations search and results
        $('#search-organizations').val(''); // Clear the search input
        $('#organization-results').empty();  // Clear the search results
        $('#organization-results-container').remove();
    });

    // Organizations search functionality

    $('#search-organizations').on('keyup', function () {
        let query = $(this).val();

        if (query.trim() === '') {
            // Clear the results and remove the results container if the input is empty
            $('#organization-results-container').remove();
            return;
        }

        $.ajax({
            url: getDataHome,
            type: "GET",
            data: { query: query },
            success: function (data) {
                // Remove the existing results container before appending new results
                $('#organization-results-container').remove();

                // If there are organizations found, dynamically create the container and append results
                if (data.response.organizations.length > 0) {
                    let resultHTML = `
                <div id="organization-results-container">
                    <div class="card mb-1 customCard">
                        <div class="card-body">
                            <ul class="list-group" id="organization-results" style="height: 210px; overflow-y: auto; max-width: 650px;">`;

                    // Loop through organizations and build list items
                    data.response.organizations.forEach(function (organization, index) {
                        let organizationLink = organizationUrl.replace(':id', organization.id);
                        resultHTML += `
                    <li class="list-group-item">
                        <a href="${organizationLink}" class="organization-link d-flex justify-content-between align-items-start flex-column flex-md-row">
                            <div class="organization-details d-flex align-items-start mb-2 mb-md-0">
                                <span class="material-icons">corporate_fare</span>
                                <span class="organization-name ml-2">${organization.name}</span>
                            </div>
                            <div class="organization-location-details d-flex align-items-start">
                                <span class="dot-separator mr-2">•</span>
                                <span class="organization-location">${organization.city}, ${organization.address}</span>
                            </div>
                        </a>
                    </li>`;

                        // Add separator line only if there are more than one record and not the last item
                        if (data.response.organizations.length > 1 && index < data.response.organizations.length - 1) {
                            resultHTML += `<div class="separator-line"></div>`;
                        }
                    });

                    resultHTML += `
                            </ul>
                        </div>
                    </div>
                </div>`;

                    // Append the dynamically generated result container and its content to the parent
                    $('#nav-organizations').append(resultHTML);
                } else {
                    $('#nav-organizations').append(`
                <div id="organization-results-container" class="fixed-card-container d-flex justify-content-center align-items-center">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="/img/folder.png" alt="Folder Icon" style="width: 52px; height: 43px;" class="mt-4">
                            <p class="card-text customText">We're sorry, but '${query}' is not currently in our database. Please add this organization to our database.</p>
                            <a href="${addOrganizationUrl}" class="btn btn-primary mb-2 custmBtn" id="add-organization">Add Organization</a>
                        </div>
                    </div>
                </div>
                `);
                }
            }
        });
    });


    // Peers search functionality
    $('#search-peers').on('keyup', function () {
        let query = $(this).val();

        if (query.trim() === '') {
            // Clear the results and remove the results container if the input is empty
            $('#peer-results-container').remove();
            return;
        }

        $.ajax({
            url: getDataHome,
            type: "GET",
            data: { query: query },
            success: function (data) {
                // Remove the existing results container before appending new results
                $('#peer-results-container').remove();

                // If there are peers found, dynamically create the container and append results
                if (data.response.peers.length > 0) {
                    let resultHTML = `
                    <div id="peer-results-container">
                        <div class="card mb-1 customCard">
                            <div class="card-body">
                                <ul class="list-group" id="peer-results" style="height: 210px; overflow-y: auto; max-width: 650px;">`;

                    // Loop through peers and build list items
                    data.response.peers.forEach(function (peer, index) {
                        let peerLink = peerUrl.replace(':id', peer.id);
                        resultHTML += `
                        <li class="list-group-item">
                            <a href="${peerLink}" class="peer-link d-flex justify-content-between align-items-start flex-column flex-md-row">
                                <div class="peer-details d-flex align-items-start mb-2 mb-md-0">
                                    <img src="/img/peerlogo.png" alt="Peer Icon" style="width: 24px; height: 24px;">
                                    <span class="peer-name ml-2">${peer.firstName} ${peer.lastName}</span>
                                </div>
                                <div class="peer-job-details d-flex align-items-start">
                                    <span class="dot-separator mr-2">•</span>
                                    <span class="peer-job-title">${peer.jobTitle}</span>
                                </div>
                            </a>
                        </li>`;

                        // Add separator line only if there are more than one peer and not the last item
                        if (data.response.peers.length > 1 && index < data.response.peers.length - 1) {
                            resultHTML += `<div class="separator-line"></div>`;
                        }
                    });

                    resultHTML += `
                                </ul>
                            </div>
                        </div>
                    </div>`;

                    // Append the dynamically generated result container and its content to the parent
                    $('#nav-peers').append(resultHTML);
                } else {
                    $('#nav-peers').append(`
                    <div id="peer-results-container" class="fixed-card-container d-flex justify-content-center align-items-center">
                        <div class="card text-center">
                            <div class="card-body">
                                <img src="/img/folder.png" alt="Folder Icon" style="width: 52px; height: 43px;" class="mt-4">
                                <p class="card-text customText">We're sorry, but '${query}' is not currently in our database. Please add this peer to our database.</p>
                                <a href="${addPeerUrl}" class="btn btn-primary mb-2 custmBtn" id="add-peer">Add Peer</a>
                            </div>
                        </div>
                    </div>
                    `);
                }
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
    getVisitorId().then(function(visitorId) {
        // Prepare the form data for AJAX submission
        var formData = {
            visitorId: visitorId,  // Include visitor ID here
        };
        $.ajax({
            url: addOrganizationUrl,
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

    // Call getLocation on page
    window.onload = getLocation();
});

