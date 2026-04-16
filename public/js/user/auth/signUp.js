$(document).ready(function () {

    var timeLeft = 59; // Total time in seconds
    var timerElement = $('#timer');
    var timerInterval;

    function updateTimer() {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerElement.text('0s').hide();
            $("#resendVerificationCode").show();
            sendOtpCodeStatus = true;
            return;
        }
        timerElement.text(timeLeft + 's');
        timeLeft--;
    }

    function startTimer() {
        // Clear any existing interval
        if (timerInterval) {
            clearInterval(timerInterval);
        }

        // Reset timeLeft and update timer display
        timeLeft = 59;
        timerElement.text(timeLeft + 's').show();

        // Start the timer
        timerInterval = setInterval(updateTimer, 1000);
    }


    // Function to validate email format
    function validateEmail(email) {
        const regularExpression = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regularExpression.test(String(email).toLowerCase());
    }

    $("#btnEmail").click(function (e) {
        e.preventDefault();
        if (timeLeft == 59 && sendOtpCodeStatus == true) {
            $("#verificationDiv").hide();
            let email = $("#email").val();

            $("#verificationDiv").hide();
            $("#emailError").text("").hide();
            $("#email").removeClass("is-invalid").css('cursor', 'default');
            $("#verificationCodeError").text("").hide();
            $("#verificationCode").removeClass("is-invalid");
            $("#backendVerificationCodeError").text("").hide().removeClass("is-invalid");

            if (email === "" || !validateEmail(email)) {
                let errorMessage = email === "" ? "Email required." : "Sorry, the email is not recognized.";
                $("#emailError").text(errorMessage).show();
                $("#email").focus().addClass("is-invalid").css('cursor', 'default');
                $("#btnEmail").attr("disabled", false);
            } else {
                sendOtp();
            }
        }
        else if (timeLeft == 0 && sendOtpCodeStatus == true){
            return false;
        }
        else{
            return false;
        }
    });

    function sendOtp() {
        $("#email").removeClass("is-invalid").css('cursor', 'default');
        $("#btnEmail").attr('disabled', true);
        // Start the loader
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: '/send-otp/signUp', // Use the form's action attribute as the URL
            data: $("#signUpForm").serialize(), // Serialize the form data
            dataType: "json", // Specify the expected response data type
            success: function (responseSuccess) {
                // Stop the loader
                $.LoadingOverlay("hide");
                // Handle the success response here
                if (responseSuccess.response.status == true) {
                    $("#email").attr("readonly", true).removeClass("is-invalid").css('cursor', 'pointer');
                    $("#verificationCode").val("");
                    $("#divResendCode").show();
                    $("#verificationDiv").show();
                    $("#btnEmail").hide();
                    $("#btnContinue").show().attr("disabled", false);
                    $("#resendVerificationCode").hide();
                    toastr.success(responseSuccess.response.message);
                    $("#timer").text("59s").show();
                    // Start the timer
                    startTimer();
                    sendOtpCodeStatus = false;
                }
            },
            error: function (xhr, status, error) {
                // Handle any errors here
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#btnEmail").attr('disabled', false).show();
                $("#btnContinue").hide();
                $("#divResendCode").hide();
                $("#verificationDiv").hide();
                $("#email").attr("readonly", false).removeClass("is-invalid").css('cursor', 'default');
                sendOtpCodeStatus = true;
                if (xhr.responseJSON.response.status == false) {
                    if (xhr.responseJSON.response.message == "An account with the provided email already exists, please sign in.") {
                        $('#alertModal').modal('show');
                        $("#message").text(xhr.responseJSON.response.message);

                        $('#okButton').click(function () {
                            window.location.href = '/sign-in';
                        });
                        return false;
                    }
                    else {
                        toastr.error(xhr.responseJSON.response.message);
                        return false;
                    }
                }
            }
        });
    }

    $("#resendVerificationCode").click(function (e) {
        e.preventDefault();

        if (timeLeft == 0 || (timeLeft == 59 && sendOtpCodeStatus == false)) {
            $("#btnContinue").attr('disabled', true);
            $("#emailError").text("").hide();
            $("#email").removeClass("is-invalid").css('cursor', 'default');
            $("#verificationCodeError").text("").hide();
            $("#verificationCode").removeClass("is-invalid");
            $("#backendVerificationCodeError").text("").hide().removeClass("is-invalid");

            let email = $("#email").val();
            if (email === "" || !validateEmail(email)) {
                let errorMessage = email === "" ? "Email required." : "Sorry, the email is not recognized.";
                $("#emailError").text(errorMessage).show();
                $("#email").focus().addClass("is-invalid").css('cursor', 'default');
                $("#btnEmail").attr("disabled", false);
            } else {
                sendOtp();
            }
        }
        else {
            return false;
        }

    });


    $("#btnContinue").click(function (e) {
        $("#emailError").text("").hide();
        $("#email").removeClass("is-invalid").css('cursor', 'default');
        $("#verificationCodeError").text("").hide();
        $("#verificationCode").removeClass("is-invalid");
        $("#backendVerificationCodeError").text("").hide().removeClass("is-invalid");
        let email = $("#email").val();

        if (email === "" || !validateEmail(email)) {
            let errorMessage = email === "" ? "Email required." : "Sorry, the email is not recognized.";
            $("#emailError").text(errorMessage).show();
            $("#email").focus().addClass("is-invalid").css('cursor', 'default');
            $("#btnEmail").attr("disabled", false).show();
            $("#verificationDiv").hide();
            $("#btnContinue").hide();
            e.preventDefault();
        } else {
            $("#email").attr("readonly", true);
            let verificationCode = $("#verificationCode").val();

            // verificationCode length
            if (verificationCode.length == 0) {
                $("#verificationCodeError").text("Verification code required").show();
                $("#verificationCode").focus().addClass("is-invalid");
                e.preventDefault();
                return false;
            }
            else if (verificationCode.length != 6) {
                $("#verificationCodeError").text("Verification code must be of 6 digits").show();
                $("#verificationCode").focus().addClass("is-invalid");
                e.preventDefault();
                return false;
            }
        }

    });

    if (sessionSocialAuth == "true") {
        toastr.success("Verification code has been sent successfully.");
        $("#timer").text("59s").show();
        // Start the timer
        startTimer();
        sendOtpCodeStatus = false;
    }
});
