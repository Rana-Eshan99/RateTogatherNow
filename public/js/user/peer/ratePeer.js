$(document).ready(function () {
    var charCount = $("#experience").val().length;
    $("#charCount").text(charCount + "/600");

    const radioButtons = [
        { name: "easyWork", errorId: "easyWorkError", errorMessage: "Easy work rating must be between 1 and 5" },
        { name: "workAgain", errorId: "workAgainError", errorMessage: "Work again rating must be between yes and no" },
        { name: "dependableWork", errorId: "dependableWorkError", errorMessage: "Dependable work rating must be between 1 and 5" },
        { name: "communicateUnderPressure", errorId: "communicateUnderPressureError", errorMessage: "Communicate under pressure rating must be between 1 and 5" },
        { name: "meetDeadline", errorId: "meetDeadlineError", errorMessage: "Meet deadline rating must be between 1 and 5" },
        { name: "receivingFeedback", errorId: "receivingFeedbackError", errorMessage: "Receiving feedback rating must be between 1 and 5" },
        { name: "respectfullOther", errorId: "respectfullOtherError", errorMessage: "Respectful work rating must be between 1 and 5" },
        { name: "assistOther", errorId: "assistOtherError", errorMessage: "Assist other rating must be between 1 and 5" },
        { name: "collaborateTeam", errorId: "collaborateTeamError", errorMessage: "Collaborate team rating must be between 1 and 5" },
    ];

    $('input[type=radio]').change(function () {
        if (!pageLoad) {
            return false;
        }

        let radioButton = radioButtons.find(rb => rb.name === this.name);
        let value = parseInt(this.value);

        if (radioButton) {
            if (radioButton.name === "workAgain") {
                if (value < 0 || value > 1) {
                    $(`#${radioButton.errorId}`).text(radioButton.errorMessage).show();
                } else {
                    $(`#${radioButton.errorId}`).text("").hide().removeClass("invalid-feedback");
                }
            } else if (isNaN(value) || value < 1 || value > 5) {
                $(`#${radioButton.errorId}`).text(radioButton.errorMessage).show();
            } else {
                $(`#${radioButton.errorId}`).text("").hide().removeClass("invalid-feedback");
            }
        }
    });

    function getFormData() {
        return [
            { name: "easyWork", value: $('input[name="easyWork"]:checked').val() || null },
            { name: "workAgain", value: $('input[name="workAgain"]:checked').val() || null },
            { name: "dependableWork", value: $('input[name="dependableWork"]:checked').val() || null },
            { name: "communicateUnderPressure", value: $('input[name="communicateUnderPressure"]:checked').val() || null },
            { name: "meetDeadline", value: $('input[name="meetDeadline"]:checked').val() || null },
            { name: "receivingFeedback", value: $('input[name="receivingFeedback"]:checked').val() || null },
            { name: "respectfullOther", value: $('input[name="respectfullOther"]:checked').val() || null },
            { name: "assistOther", value: $('input[name="assistOther"]:checked').val() || null },
            { name: "collaborateTeam", value: $('input[name="collaborateTeam"]:checked').val() || null },
            { name: "experience", value: $("#experience").val() || null }
        ];
    }

    function checkChanges() {
        let currentFormData = getFormData();
        console.log(currentFormData);
        for (let i = 0; i < originalFormData.length; i++) {
            if (originalFormData[i].value !== currentFormData[i].value) {
                hasChanges = true;
                return true; // Changes detected
            }
        }
        hasChanges = false;
        return false; // No changes detected
    }

    $("input[type='radio']").change(function () {
        checkChanges(); // Trigger change detection when radio button is changed
    });

    $("#experience").keyup(function () {
        checkChanges(); // Trigger change detection when typing in the experience field
    });

    $("#btnRatePeer").click(function (e) {
        $(".invalid-feedback").text("").hide();

        let hasError = false;

        radioButtons.forEach(radioButton => {
            let value = $(`input[name="${radioButton.name}"]:checked`).val();
            if (radioButton.name === "workAgain") {
                if (value !== '0' && value !== '1') {
                    e.preventDefault();
                    $(`#${radioButton.errorId}`).text(radioButton.errorMessage).show();
                    hasError = true;
                }
            } else {
                if (!value || parseInt(value) < 1 || parseInt(value) > 5) {
                    e.preventDefault();
                    $(`#${radioButton.errorId}`).text(radioButton.errorMessage).show();
                    hasError = true;
                }
            }
        });

        let experience = $("#experience").val();
        if (!experience || experience.length === 0) {
            e.preventDefault();
            $("#experienceError").text("Experience required").show();
            hasError = true;
        } else if (experience.length > 600) {
            e.preventDefault();
            $("#experienceError").text("Experience must not exceed 600 characters").show();
            hasError = true;
        }

        if (!hasError) {
            if (!checkChanges()) {
                e.preventDefault();
                toastr.info("No changes detected. Please make changes before submitting.");

            } else {
                $.LoadingOverlay("show");
            }
        }
    });

    $('#experience').keyup(function () {
        $("#experienceError").text("").hide();
        var maxLength = 600;
        var currentValue = $(this).val();
        currentValue = currentValue.replace(/\r\n/g, '\n');
        var currentLength = currentValue.length;

        if (currentLength <= maxLength) {
            $('#charCount').text(currentLength + '/' + maxLength);
        }

        if (currentLength > maxLength) {
            $(this).val(currentValue.substring(0, maxLength));
            $('#charCount').text(maxLength + '/' + maxLength);
        }
    });

    if (sessionPeerRated == "true") {
        $('#alertModal').modal('show');
        sessionPeerRated = "false";

        $('#btnClose').click(function () {
            $("#alertModal").modal('hide');
            window.location.href = redirectBackUrl;
        });
    }

    function updateStarRating(overAllRating) {
        if (overAllRating >= 0 && overAllRating <= 5) {
            var fullStars = Math.floor(overAllRating); // Full stars
            var partialStar = overAllRating % 1 >= 0.5; // Check if there should be a half star
            // Reset all stars
            $('.star').prop('checked', false);

            // Fill full stars
            for (var i = 1; i <= fullStars; i++) {
                $('#star' + i).prop('checked', true);
            }

            // Handle partial star (if any)
            if (partialStar && fullStars < 5) {
                $('#star' + (fullStars + 1)).prop('indeterminate', true); // Use indeterminate state for partial fill
            }
        }
    }

    // Example usage
    updateStarRating(overAllRating);

    const checkRatingStars = (rating, name) => {
        if (name == "workAgain") {
            if (rating == 1) {
                $("#workAgainYes").prop('checked', true);
            }
            else if (rating == 0) {
                $("#workAgainNo").prop('checked', true);
            }
            else {
                $("#workAgainNo").prop('checked', false);
                $("#workAgainYes").prop('checked', false);
            }
        }
        if (rating >= 0 && rating <= 5) {
            for (let i = 1; i <= rating; i++) {
                $(`#${name}Star${i}`).prop('checked', true);
            }
        }
    };

    checkRatingStars(easyWork, 'easyWork');
    checkRatingStars(workAgain, 'workAgain');
    checkRatingStars(dependableWork, 'dependableWork');
    checkRatingStars(communicateUnderPressure, 'communicateUnderPressure');
    checkRatingStars(meetDeadline, 'meetDeadline');
    checkRatingStars(receivingFeedback, 'receivingFeedback');
    checkRatingStars(respectfullOther, 'respectfullOther');
    checkRatingStars(assistOther, 'assistOther');
    checkRatingStars(collaborateTeam, 'collaborateTeam');

    var pageLoad = true;

    // Initialize originalFormData after all values are captured
    originalFormData = getFormData();
});
