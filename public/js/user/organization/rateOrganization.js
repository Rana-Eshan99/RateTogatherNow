$(document).ready(function () {
    var originalFormData = getFormData();
    let hasChanges = false;

    // Initialize character count
    var charCount = $("#experience").val().length;
    $("#charCount").text(charCount + "/600");

    // Function to get the current form data
    function getFormData() {
        return [
            { name: "employeeHappiness", value: $("input[name='employeeHappiness']:checked").val() || null },
            { name: "companyCulture", value: $("input[name='companyCulture']:checked").val() || null },
            { name: "careerDevelopment", value: $("input[name='careerDevelopment']:checked").val() || null },
            { name: "workLifeBalance", value: $("input[name='workLifeBalance']:checked").val() || null },
            { name: "compensationBenefit", value: $("input[name='compensationBenefit']:checked").val() || null },
            { name: "jobStability", value: $("input[name='jobStability']:checked").val() || null },
            { name: "workplaceDEI", value: $("input[name='workplaceDEI']:checked").val() || null },
            { name: "companyReputation", value: $("input[name='companyReputation']:checked").val() || null },
            { name: "workplaceSS", value: $("input[name='workplaceSS']:checked").val() || null },
            { name: "growthFuturePlan", value: $("input[name='growthFuturePlan']:checked").val() || null },
            { name: "experience", value: $("#experience").val() || null }
        ];
    }

    // Check for changes in form data
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

    // Attach event listeners to radio buttons and #experience
    $("input[type='radio'], #experience").on("change keyup", function () {
        checkChanges();
    });

    // Validate the Forms and prevent submission if no changes
    $("#btnRateOrganization").click(function (e) {
        $(".invalid-feedback").text("").hide();

        let hasError = false;

        const validateRating = (name, errorId, errorMessage) => {
            let value = $(`input[name="${name}"]:checked`).val();
            if (value) {
                if (parseInt(value) < 1 || parseInt(value) > 5) {
                    e.preventDefault();
                    $(`#${errorId}`).text(errorMessage).show();
                    hasError = true;
                }
            } else {
                e.preventDefault();
                $(`#${errorId}`).text(`${errorMessage} required`).show();
                hasError = true;
            }
        };

        validateRating("employeeHappiness", "employeeHappinessError", "Employee happiness rating must be between 1 and 5");
        validateRating("companyCulture", "companyCultureError", "Company culture rating must be between 1 and 5");
        validateRating("careerDevelopment", "careerDevelopmentError", "Career development rating must be between 1 and 5");
        validateRating("workLifeBalance", "workLifeBalanceError", "Work-life balance rating must be between 1 and 5");
        validateRating("compensationBenefit", "compensationBenefitError", "Compensation & benefit rating must be between 1 and 5");
        validateRating("jobStability", "jobStabilityError", "Job stability rating must be between 1 and 5");
        validateRating("workplaceDEI", "workplaceDEIError", "Workplace diversity, equity and inclusion rating must be between 1 and 5");
        validateRating("companyReputation", "companyReputationError", "Company reputation rating must be between 1 and 5");
        validateRating("workplaceSS", "workplaceSSError", "Workplace safety & security rating must be between 1 and 5");
        validateRating("growthFuturePlan", "growthFuturePlanError", "Company growth future plan rating must be between 1 and 5");

        // Experience validation
        let experience = $("#experience").val();
        if (experience === "" || experience.length === 0) {
            e.preventDefault();
            $("#experienceError").text("Experience required").show();
            hasError = true;
        } else if (experience.length > 600) {
            e.preventDefault();
            $("#experienceError").text("Experience must not exceed 600 characters").show();
            hasError = true;
        }

        // Check for errors
        if (!hasError) {
            // If no changes, prevent form submission
            if (!hasChanges) {
                e.preventDefault();
                toastr.info("No changes detected. Please make changes before submitting.");
            } else {
                // Show loader if there are no errors and there are changes
                $.LoadingOverlay("show");
            }
        }
    });

    // Character count handling for #experience
    $('#experience').keyup(function () {
        $("#experienceError").text("").hide();

        var maxLength = 600;
        var currentValue = $(this).val().replace(/\r\n/g, '\n');
        var currentLength = currentValue.length;

        if (currentLength <= maxLength) {
            $('#charCount').text(currentLength + '/' + maxLength);
        }

        if (currentLength > maxLength) {
            $(this).val(currentValue.substring(0, maxLength));
            $('#charCount').text(maxLength + '/' + maxLength);
        }
    });

    // Check rating stars
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

    // Modal logic
    if (sessionOrganizationRated == "true") {
        $('#alertModal').modal('show');
        sessionOrganizationRated = "false";
        $('#btnClose').click(function () {
            $("#alertModal").modal('hide');
            window.location.href = redirectBackUrl;
        });
    }

    // Radio buttons validation on change
    const radioButtons = [
        { name: "employeeHappiness", errorId: "employeeHappinessError", errorMessage: "Employee happiness rating must be between 1 and 5" },
        { name: "companyCulture", errorId: "companyCultureError", errorMessage: "Company culture rating must be between 1 and 5" },
        { name: "careerDevelopment", errorId: "careerDevelopmentError", errorMessage: "Career development rating must be between 1 and 5" },
        { name: "workLifeBalance", errorId: "workLifeBalanceError", errorMessage: "Work-life balance rating must be between 1 and 5" },
        { name: "compensationBenefit", errorId: "compensationBenefitError", errorMessage: "Compensation & benefit rating must be between 1 and 5" },
        { name: "jobStability", errorId: "jobStabilityError", errorMessage: "Job stability rating must be between 1 and 5" },
        { name: "workplaceDEI", errorId: "workplaceDEIError", errorMessage: "Workplace diversity, equity and inclusion rating must be between 1 and 5" },
        { name: "companyReputation", errorId: "companyReputationError", errorMessage: "Company reputation rating must be between 1 and 5" },
        { name: "workplaceSS", errorId: "workplaceSSError", errorMessage: "Workplace safety & security rating must be between 1 and 5" },
        { name: "growthFuturePlan", errorId: "growthFuturePlanError", errorMessage: "Company growth future plan rating must be between 1 and 5" }
    ];

    $('input[type=radio]').change(function () {
        let radioButton = radioButtons.find(rb => rb.name === this.name);
        let value = parseInt(this.value);

        if (radioButton) {
            if (isNaN(value) || value < 1 || value > 5) {
                $(`#${radioButton.errorId}`).text(radioButton.errorMessage).show();
            } else {
                $(`#${radioButton.errorId}`).text("").hide().removeClass(".invalid-feedback");
            }
        }
    });
});

