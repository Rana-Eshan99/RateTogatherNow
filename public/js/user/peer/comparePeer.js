$(document).ready(function () {
    let compareCursorValue = false;
    let newUpdatedSecondUrl = "";
    let getComparePeerUrl = "";
    // Initialize the Peer select box
    function formatSelection(state) {
        let placeholderData = "Search Peer";
        if (!state.id) {
            return $('<span><img src="' + searchIconUrl + '" class="img-responsive" alt="Search" style="height:24px; width:24px; object-fit: cover;"></img> ' + placeholderData + '</span>');
        }
        return $('<span><img src="' + searchIconUrl + '" class="img-responsive" alt="Search" style="height:24px; width:24px;  object-fit: cover;"></img> ' + state.text + '</span>');
    }

    $('#searchComparePeer').select2({
        width: '100%',
        templateSelection: formatSelection,
        placeholder: formatSelection,
        templateResult: formatOption,
    });

    function formatOption(option) {
        if (!option.id) {
            return option.text;
        }
        const peerName = $(option.element).data("peer-name");
        const jobTitle = $(option.element).data("job-title");
        const organization = $(option.element).data("organization");

        return $(
            `<div>
                <strong>${peerName}</strong><br>
                <span>${jobTitle} At ${organization}</span>
            </div>`
        );
    }

    function formatSelection(option) {
        return option.text; // Display selected text only
    }
    // Focus on the search box when searchComparePeer Select2 opens
    $('#searchComparePeer').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    // Click on the first div redirect to organization details
    let divUrl = $('#divUrl').val();
    $('#firstDivOverAllRating').on('click', function () {
        window.location.href = divUrl;
    });

    // On Click reset button set all settings to defaults
    $("#btnReset").click(function (e) {
        e.preventDefault();
        compareCursorValue = false;
        newUpdatedSecondUrl = "";
        getComparePeerUrl = "";
        $("#comparePeerName").text('').hide().attr('title', '');
        $("#searchComparePeerDiv").show();
        $("#overAllRatingCompare").text("N/A");
        $("#btnReset")
            .prop('disabled', true) // Disable the button
            .removeClass() // Remove all previous classes
            .addClass('btn resetBtnColor'); // Add the new classes
        $("#searchComparePeer").val('');
        $("#comparePeerDiv").css("background-color", "#F7F6F6");
        // Set comparePeerDiv style to default
        $('#comparePeerDiv').css('cursor', 'default');

        $('#searchComparePeer').select2({
            width: '100%',
            templateSelection: formatSelection,
            placeholder: formatSelection,
            templateResult: formatOption,
        });

        resetRadioButtonCompare();
    });

    // Global function to reset the radio buttons in the compare section
    function resetRadioButtonCompare() {
        $("input[name='easyWorkCompare']").prop('checked', false);
        $("input[name='dependableWorkCompare']").prop('checked', false);
        $("input[name='communicateUnderPressureCompare']").prop('checked', false);
        $("input[name='meetDeadlineCompare']").prop('checked', false);
        $("input[name='receivingFeedbackCompare']").prop('checked', false);
        $("input[name='respectfullOtherCompare']").prop('checked', false);
        $("input[name='assistOtherCompare']").prop('checked', false);
        $("input[name='collaborateTeamCompare']").prop('checked', false);
        $("#compareWorkAgainBox").css("background-color", "white");
        $("#workAgainYesRatingCompare").text("");

    }

    // On Input Load Organization Compared Rating
    $('#searchComparePeer').on('change', function () {
        let peerId = $(this).val();

        if (peerId.length) {
            // Replace the placeholder `:id` with the selected peerId
            getComparePeerUrl = routeName.replace(':id', peerId);

            resetRadioButtonCompare();

            // Start the loader
            $.LoadingOverlay("show");
            $.ajax({
                type: "GET",
                url: getComparePeerUrl,
                success: function (responseSuccess) {
                    // Stop the loader
                    $.LoadingOverlay("hide");
                    // Handle successful response
                    if (responseSuccess.response.status == true) {
                        $("#btnReset")
                            .prop('disabled', false) // Disable the button
                            .removeClass() // Remove all previous classes
                            .addClass('btn btn-primary customBtnColor'); // Add the new classes
                        $("#comparePeerDiv").css("background-color", "#FFFDFD");
                        $("#comparePeerDiv").css("cursor", "pointer");
                        $("#comparePeerName").text(responseSuccess.response.data.peerFullName).show();
                        $("#comparePeerName").attr('title', responseSuccess.response.data.peerFullName);
                        $("#searchComparePeerDiv").hide();
                        $("#searchComparePeer").val('');
                        $("#overAllRatingCompare").text(responseSuccess.response.data.overAllRating).show();

                        // Replace the placeholder `:id` with the selected peerId & update the newUpdatedSecondUrl with the secondDivUrl
                        newUpdatedSecondUrl = secondDivUrl.replace(':id', peerId);

                        compareCursorValue = true;
                        // Now checked the star
                        let easyWorkCompare = responseSuccess.response.data.easyWorkRating;
                        let dependableWorkCompare = responseSuccess.response.data.dependableWorkRating;
                        let communicateUnderPressureCompare = responseSuccess.response.data.communicateUnderPressureRating;
                        let meetDeadlineCompare = responseSuccess.response.data.meetDeadlineRating;
                        let receivingFeedbackCompare = responseSuccess.response.data.receivingFeedbackRating;
                        let respectfullOtherCompare = responseSuccess.response.data.respectfullOtherRating;
                        let assistOtherCompare = responseSuccess.response.data.assistOtherRating;
                        let collaborateTeamCompare = responseSuccess.response.data.collaborateTeamRating;
                        let workAgainYesPercentage = responseSuccess.response.data.workAgainYesPercentage;
                        let workAgainNoPercentage = responseSuccess.response.data.workAgainNoPercentage;


                        checkRatingStars(easyWorkCompare, 'easyWorkCompare');
                        checkRatingStars(dependableWorkCompare, 'dependableWorkCompare');
                        checkRatingStars(communicateUnderPressureCompare, 'communicateUnderPressureCompare');
                        checkRatingStars(meetDeadlineCompare, 'meetDeadlineCompare');
                        checkRatingStars(receivingFeedbackCompare, 'receivingFeedbackCompare');
                        checkRatingStars(respectfullOtherCompare, 'respectfullOtherCompare');
                        checkRatingStars(assistOtherCompare, 'assistOtherCompare');
                        checkRatingStars(collaborateTeamCompare, 'collaborateTeamCompare');

                        if ((workAgainYesPercentage > workAgainNoPercentage || workAgainYesPercentage >= workAgainNoPercentage) && !(workAgainYesPercentage === 0 && workAgainNoPercentage === 0)) {
                            $("#compareWorkAgainBox").css("background-color", "#11951E");
                            $("#workAgainYesRatingCompare").text(workAgainYesPercentage + "% Yes");
                        } else if (workAgainNoPercentage > workAgainYesPercentage) {
                            $("#compareWorkAgainBox").css("background-color", "#F94747");
                            $("#workAgainYesRatingCompare").text(workAgainNoPercentage + "% No");
                        } else if (workAgainYesPercentage === 0 && workAgainNoPercentage === 0) {
                            $("#compareWorkAgainBox").css("background-color", "#11951E");
                            $("#workAgainYesRatingCompare").text("0% Yes/No");
                        }

                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.log(error);
                    // Stop the loader
                    $.LoadingOverlay("hide");
                    $("#btnReset")
                        .prop('disabled', true) // Disable the button
                        .removeClass() // Remove all previous classes
                        .addClass('btn resetBtnColor'); // Add the new classes
                    compareCursorValue = false;
                    newUpdatedSecondUrl = "";
                    getComparePeerUrl = "";
                    $("#searchComparePeer").val('');
                    $("#searchComparePeerDiv").css("background-color", "#F7F6F6");
                    resetRadioButtonCompare();
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

    // On the Click of Compare Div redirect back to the peer details
    $('#comparePeerDiv').on('click', function () {
        // Check if the cursor property is set to 'pointer'
        let cursorStyle = $(this).css('cursor');

        if (cursorStyle === 'pointer' && compareCursorValue == true) {
            compareCursorValue = true;
            window.location.href = newUpdatedSecondUrl;
        }
    });



    // Checked the organization rating star on load
    const checkRatingStars = (rating, name) => {
        if (rating >= 0 && rating <= 5) {
            for (let i = 1; i <= rating; i++) {
                $(`#${name}Star${i}`).prop('checked', true);
            }
        }
    };

    checkRatingStars(easyWork, 'easyWork');
    checkRatingStars(dependableWork, 'dependableWork');
    checkRatingStars(communicateUnderPressure, 'communicateUnderPressure');
    checkRatingStars(meetDeadline, 'meetDeadline');
    checkRatingStars(receivingFeedback, 'receivingFeedback');
    checkRatingStars(respectfullOther, 'respectfullOther');
    checkRatingStars(assistOther, 'assistOther');
    checkRatingStars(collaborateTeam, 'collaborateTeam');

});
