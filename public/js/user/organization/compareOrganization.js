$(document).ready(function () {
    let compareCursorValue = false;
    let newUpdatedSecondUrl = "";
    let getCompareOrganizationUrl = "";
    // Initialize the organization and department select box
    function formatSelection(state) {
        let placeholderData = "Search Organization";
        if (!state.id) {
            return $('<span><img src="' + searchIconUrl + '" class="img-responsive" alt="Search" style="height:24px; width:24px; object-fit: cover;"></img> ' + placeholderData + '</span>');
        }
        return $('<span><img src="' + searchIconUrl + '" class="img-responsive" alt="Search" style="height:24px; width:24px;  object-fit: cover;"></img> ' + state.text + '</span>');
    }

    // Function to format the dropdown options
    function formatOption(state) {
        if (!state.id) {
            return $('<span><img src="' + searchIconUrl + '" class="img-responsive" alt="Search" style="height:24px; width:24px; object-fit: cover;"></img> ' + state.text + '</span>');
        }

        // Custom format: Bold organization name and regular address
        let organizationName = state.text.split(' - ')[0];
        let organizationAddress = state.text.split(' - ')[1];
        return $(
            '<span><strong>' + organizationName + '</strong> <br>' + organizationAddress + '</span>'
        );
    }

    $('#searchCompareOrganization').select2({
        width: '100%',
        templateSelection: formatSelection,
        placeholder: formatSelection,
        templateResult: formatOption,

    });

    // Focus on the search box when searchCompareOrganization Select2 opens
    $('#searchCompareOrganization').on('select2:open', function (e) {
        // Get the search box input and focus on it
        document.querySelector('.select2-search__field').focus();
    });

    let firstDivUrl = $('#firstDivUrl').val();
    $('#firstDivOverAllRating').on('click', function () {
        window.location.href = firstDivUrl;
    });

    $("#btnReset").click(function (e) {
        e.preventDefault();
        compareCursorValue = false;
        $("#compareOrganizationName").text('').hide().attr('title', '');
        $("#searchCompareOrganizationDiv").show();
        $("#overAllRatingCompare").text("N/A");
        newUpdatedSecondUrl = "";
        getCompareOrganizationUrl = "";
        $("#btnReset")
            .prop('disabled', true) // Disable the button
            .removeClass() // Remove all previous classes
            .addClass('btn btnHeight customBorderRadius resetBtnColor'); // Add the new classes
        $("#searchCompareOrganization").val('');
        $("#compareOrganizationDiv").css("background-color", "#F7F6F6");
        // Set compareOrganizationDiv style to default
        $('#compareOrganizationDiv').css('cursor', 'default');

        $('#searchCompareOrganization').select2({
            width: '100%',
            templateSelection: formatSelection,
            placeholder: formatSelection,
            templateResult: formatOption,
        });

        resetRadioButtonCompare();
    });

    function resetRadioButtonCompare() {
        $("input[name='employeeHappinessCompare']").prop('checked', false);
        $("input[name='companyCultureCompare']").prop('checked', false);
        $("input[name='careerDevelopmentCompare']").prop('checked', false);
        $("input[name='workLifeBalanceCompare']").prop('checked', false);
        $("input[name='compensationBenefitCompare']").prop('checked', false);
        $("input[name='jobStabilityCompare']").prop('checked', false);
        $("input[name='workplaceDEICompare']").prop('checked', false);
        $("input[name='companyReputationCompare']").prop('checked', false);
        $("input[name='workplaceSSCompare']").prop('checked', false);
        $("input[name='growthFuturePlanCompare']").prop('checked', false);
    }


    // ////////
    // Checked the organization rating star on load
    const checkRatingStars = (rating, name) => {
        if (rating >= 0 && rating <= 5) {
            for (let i = 1; i <= rating; i++) {
                $(`#${name}Star${i}`).prop('checked', true);
            }
        }
    };

    checkRatingStars(employeeHappiness, 'employeeHappiness');
    checkRatingStars(companyCulture, 'companyCulture');
    checkRatingStars(careerDevelopment, 'careerDevelopment');
    checkRatingStars(workLifeBalance, 'workLifeBalance');
    checkRatingStars(compensationBenefit, 'compensationBenefit');
    checkRatingStars(jobStability, 'jobStability');
    checkRatingStars(workplaceDEI, 'workplaceDEI');
    checkRatingStars(companyReputation, 'companyReputation');
    checkRatingStars(workplaceSS, 'workplaceSS');
    checkRatingStars(growthFuturePlan, 'growthFuturePlan');


    // On Input Load Organization Compared Rating
    $('#searchCompareOrganization').on('change', function () {
        let orgId = $(this).val();

        if (orgId.length) {
            // Replace the placeholder `:id` with the selected organizationId
            getCompareOrganizationUrl = routeName.replace(':id', orgId);

            resetRadioButtonCompare();

            // Start the loader
            $.LoadingOverlay("show");
            $.ajax({
                type: "GET",
                url: getCompareOrganizationUrl,
                success: function (responseSuccess) {
                    // Stop the loader
                    $.LoadingOverlay("hide");
                    // Handle successful response
                    if (responseSuccess.response.status == true) {
                        $("#btnReset")
                            .prop('disabled', false) // Disable the button
                            .removeClass() // Remove all previous classes
                            .addClass('btn btn-primary btnHeight customBorderRadius customBtnColor'); // Add the new classes

                        // Replace the placeholder `:id` with the selected organizationId & update the newUpdatedSecondUrl with the secondDivUrl
                        newUpdatedSecondUrl = secondDivUrl.replace(':id', orgId);

                        $("#compareOrganizationDiv").css("background-color", "#FFFDFD");
                        $("#compareOrganizationDiv").css("cursor", "pointer");
                        $("#compareOrganizationName").text(responseSuccess.response.data.name).show();
                        $("#compareOrganizationName").attr('title', responseSuccess.response.data.name);
                        $("#searchCompareOrganizationDiv").hide();
                        $("#searchCompareOrganization").val('');
                        $("#overAllRatingCompare").text(responseSuccess.response.data.overAllRating).show();
                        compareCursorValue = true;

                        // Now checked the star
                        let employeeHappinessCompare = responseSuccess.response.data.employeeHappynessRating;
                        let companyCultureCompare = responseSuccess.response.data.companyCultureOverAllRating;
                        let careerDevelopmentCompare = responseSuccess.response.data.careerDevelopmentOverAllRating;
                        let workLifeBalanceCompare = responseSuccess.response.data.workLifeBalanceOverAllRating;
                        let compensationBenefitCompare = responseSuccess.response.data.compensationBenefitOverAllRating;
                        let jobStabilityCompare = responseSuccess.response.data.jobStabilityOverAllRating;
                        let workplaceDEICompare = responseSuccess.response.data.workplaceDEIOverAllRating;
                        let companyReputationCompare = responseSuccess.response.data.companyReputationOverAllRating;
                        let workplaceSSCompare = responseSuccess.response.data.workplaceSSOverAllRating;
                        let growthFuturePlanCompare = responseSuccess.response.data.growthFuturePlanOverAllRating;


                        checkRatingStars(employeeHappinessCompare, 'employeeHappinessCompare');
                        checkRatingStars(companyCultureCompare, 'companyCultureCompare');
                        checkRatingStars(careerDevelopmentCompare, 'careerDevelopmentCompare');
                        checkRatingStars(workLifeBalanceCompare, 'workLifeBalanceCompare');
                        checkRatingStars(compensationBenefitCompare, 'compensationBenefitCompare');
                        checkRatingStars(jobStabilityCompare, 'jobStabilityCompare');
                        checkRatingStars(workplaceDEICompare, 'workplaceDEICompare');
                        checkRatingStars(companyReputationCompare, 'companyReputationCompare');
                        checkRatingStars(workplaceSSCompare, 'workplaceSSCompare');
                        checkRatingStars(growthFuturePlanCompare, 'growthFuturePlanCompare');
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
                        .addClass('btn btnHeight customBorderRadius resetBtnColor'); // Add the new classes
                    compareCursorValue = false;
                    newUpdatedSecondUrl = "";
                    getCompareOrganizationUrl = "";
                    $("#searchCompareOrganization").val('');
                    $("#compareOrganizationDiv").css("background-color", "#F7F6F6");
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

    // On Compare Organization Click show the selected organization details
    $('#compareOrganizationDiv').on('click', function () {
        // Check if the cursor property is set to 'pointer'
        let cursorStyle = $(this).css('cursor');

        if (cursorStyle === 'pointer' && compareCursorValue == true) {
            compareCursorValue = true;
            window.location.href = newUpdatedSecondUrl;
        }
    });

});
