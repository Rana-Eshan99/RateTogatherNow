document.addEventListener("DOMContentLoaded", function () {
    var buttons = document.getElementsByClassName("btnStyles");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function (button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function () {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function (button) {
                button.style.background = "#007bff"; // Change color to transparent
                button.style.color = "#fff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function () {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function () {
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
    // Initialize the Country select box
    $(".countrySelectBox").select2({
        placeholder: 'Select Country',
        width: '100%', // Set the width as per your requirement
    });

    // Focus on the search box when countryId Select2 opens
    $('#countryId').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    // Initialize the state select box
    $(".stateSelectBox").select2({
        placeholder: 'Select State or Province',
        width: '100%', // Set the width as per your requirement
    });

    // Focus on the search box when stateId Select2 opens
    $('#stateId').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    // Button Cancel clicked
    let resetCountry = false;
    $("#btnCancel").click(function (e) {
        e.preventDefault();
        // Cancel the adding peer process and redirect back to the list Url
        window.location.href = redirectBackUrl;
    });

    // Button Add Organization Clicked
    var imageValid = true;

    $('#btnAddOrganization').click(function (e) {
        var fileInput = $('#fileUpload')[0]; // Access the DOM element
        var file = fileInput.files[0];

        if (!file) {

        }
        else {
            var fileType = file.type;
            var fileSize = file.size;
            var allowedTypes = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'];
            var maxSize = 1 * 15360 * 1024; // 15MB in bytes

            if ($.inArray(fileType, allowedTypes) === -1) {
                $('#fileUploadError').text('Invalid file type. Only SVG, PNG, JPG, or GIF files are allowed.');
                fileInput.value = ''; // Clear the input
                imageValid = false;
            }
            else {
                if (fileSize > maxSize) {
                    $('#fileUploadError').text('File size exceeds 15MB. Please upload a smaller file.');
                    fileInput.value = ''; // Clear the input
                    imageValid = false;
                }
                else {
                    imageValid = true;
                    $('#fileUploadError').text(''); // Clear any previous error messages
                }
            }

        }

    });

    $("#countryId").change(function (e) {
        if (resetCountry == true) {
            resetCountry = false;
            return false;
        }
        else {
            let countryId = $("#countryId").val();
            var stateSelectBox = $("#stateId");
            // Clear existing options of the state
            stateSelectBox.empty();
            // Add custom class for Select2 to display red border at countryId
            $("#countryId").next('.select2-container').find('.select2-selection').removeClass('is-invalid-border-only');
            // Add custom class for Select2 to display red border at stateId
            $("#stateId").next('.select2-container').find('.select2-selection').removeClass('is-invalid-border-only');
            // Remove the previous error
            $("#countryIdError").html("").hide();
            // Add the default options
            stateSelectBox.append('<option value="" selected disabled>Select State or Province</option>');
            if (countryId == null || countryId == "" || countryId.length == 0) {
                // Add custom class for Select2 to display red border at countryId
                $("#countryId").next('.select2-container').find('.select2-selection').addClass('is-invalid-border-only');
                $("#countryIdError").html("Country required").show();
                $("#countryId").focus();
            }
            else {
                // Start the loader
                $.LoadingOverlay("show");
                $.ajax({
                    type: "GET",
                    url: "/state/get-states/" + countryId,
                    success: function (successResponse) {
                        // Stop the loader
                        $.LoadingOverlay("hide");
                        if (successResponse.response.status == true) {
                            // Populate the stateId select2 box with states
                            var states = successResponse.response.states; // Assuming response.states contains the list of states
                            // Check if states are empty
                            if (states.length === 0) {
                                toastr.warning('No states found.');
                            }
                            else {
                                $.each(states, function (index, state) {
                                    stateSelectBox.append('<option value="' + state.id + '" >' + state.name + '</option>');
                                });
                            }
                            // Initialize or refresh select2
                            stateSelectBox.select2({
                                placeholder: 'Select State or Province',
                                width: '100%', // Set the width as per your requirement
                            });

                            // Add a class to the stateSelectBox Select2 container after initialization
                            $(".stateSelectBox").next('.select2-container').addClass('topMargin');

                        }
                    },
                    error: function (xhr, status, error) {
                        // Stop the loader
                        $.LoadingOverlay("hide");
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
        }

    });


    // Initialize validation on the form
    $("#addOrganizationForm").validate({
        rules: {
            organizationName: {
                required: true,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            address: {
                required: true,
            },
            // Add rules for other fields here...
        },
        messages: {
            organizationName: {
                required: "Organization name required",
            },
            country: {
                required: "Country required",
            },
            state: {
                required: "State or Province required",
            },
            city: {
                required: "City required",
            },
            address: {
                required: "Address required",
            },
            // Add messages for other fields here...
        },
        errorPlacement: function (error, element) {
            var elementId = element.attr("id");
            $("#" + elementId).addClass("is-invalid");
            $("#" + elementId + "Error").html(error.text()).show();
        },
        success: function (label, element) {
            var elementId = element.id;
            $("#" + elementId).removeClass("is-invalid");
            $("#" + elementId + "Error").html("").hide();
        },
        submitHandler: function (form, event) {
            if (imageValid == false) {
                event.preventDefault();
            } else {
                $.LoadingOverlay("show");
                form.submit();
            }
        }
    });

    // Function to manually validate and clear errors for dynamically updated fields
    function clearValidationOnDynamicData(inputFieldId) {
        $("#" + inputFieldId).removeClass("is-invalid");
        $("#" + inputFieldId + "Error").html("").hide();
    }

    // Call this function to dynamically set values in disabled fields
    function populateLocationFields(city, state, country) {
        // Set values to disabled fields
        $("#city").val(city);
        $("#state").val(state);
        $("#country").val(country);

        // Manually clear validation errors when values are set
        if (city) clearValidationOnDynamicData("city");
        if (state) clearValidationOnDynamicData("state");
        if (country) clearValidationOnDynamicData("country");
    }

    // Trigger validation on stateId change
    $('#stateId').change(function () {
        let countryId = $("#countryId").val()
        if (countryId == "" || countryId == null || countryId.length == 0) {
            // Add custom class for Select2 to display red border at countryId
            $("#countryId").next('.select2-container').find('.select2-selection').addClass("is-invalid-border-only");
            $("#countryIdError").text("Country required").show();
        }
        else {
            let stateId = $("#stateId").val()
            if ((stateId == "" || stateId == null || stateId.length == 0)) {
                // Add custom class for Select2 to display red border at stateId
                $("#stateId").next('.select2-container').find('.select2-selection').addClass("is-invalid-border-only");
                $("#stateIdError").text("State required").show();
            }
            else {
                // Remove custom class for Select2 to display red border at stateId
                $("#stateId").next('.select2-container').find('.select2-selection').removeClass("is-invalid-border-only");
                $("#stateIdError").text("").hide();
            }
        }
    });

    if (sessionAddOrganization == "true") {
        // Show Modal
        $('#alertModal').modal('show');

        $('#btnClose').click(function () {
            $("#alertModal").modal('hide');
            sessionAddOrganization = "false";
            window.location.href = redirectBackUrl;
        });
    }


    window.onload = function () {
        function initialize() {
            $('form').on('keyup keypress', function (e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            const locationInput = document.getElementById("address");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");
            const cityInput = document.getElementById("city");
            const stateInput = document.getElementById("state");
            const countryInput = document.getElementById("country");

            const latitude = parseFloat(latitudeInput.value) || 59.339024834494886;
            const longitude = parseFloat(longitudeInput.value) || 18.06650573462189;

            const map = new google.maps.Map(document.getElementById("address-map"), {
                center: { lat: latitude, lng: longitude },
                zoom: 17
            });
            const marker = new google.maps.Marker({
                map: map,
                position: { lat: latitude, lng: longitude },
                visible: latitudeInput.value !== '' && longitudeInput.value !== ''
            });

            const autocomplete = new google.maps.places.Autocomplete(locationInput);
            const geocoder = new google.maps.Geocoder;

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                marker.setVisible(false);
                const place = autocomplete.getPlace();

                geocoder.geocode({ 'placeId': place.place_id }, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(lat, lng);
                        fetchLocationDetails(lat, lng); // Call function to fetch city and state/province name
                    }
                });

                if (!place.geometry) {
                    alert("No details available for input: '" + place.name + "'");
                    locationInput.value = "";
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            });

            function setLocationCoordinates(lat, lng) {
                latitudeInput.value = lat;
                longitudeInput.value = lng;
            }

            function fetchLocationDetails(lat, lng) {
                const apiKey = Key; // Replace with your Google API Key
                const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Location details:', data);
                        if (data && data.results && data.results.length > 0) {
                            const addressComponents = data.results[0].address_components;

                            // Helper function to find address component by type
                            const getAddressComponent = (type) =>
                                addressComponents.find(component => component.types.includes(type))?.long_name;

                            // Set city value
                            const city = getAddressComponent('locality') ||
                                getAddressComponent('administrative_area_level_2');

                            // Set state/province value
                            const state = getAddressComponent('administrative_area_level_1');

                            // Set country value
                            const country = getAddressComponent('country');
                            // Populate and clear validation on disabled fields
                            populateLocationFields(city, state, country);
                        }
                    })
                    .catch(error => console.error('Error fetching location details:', error));
            }

        }

        initialize();
    };



});
