$(document).ready(function() {
    $("#signinForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Email required.",
                email: "Invalid email format.",
            },
            password: {
                required: "Password required.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "email") {
                // Clear any backend error before showing frontend error
                $("#emailError").html('');
                error.appendTo("#emailError");
            } else if (element.attr("name") == "password") {
                // Clear any backend error for password if needed
                $("#passwordError").html('');
                error.appendTo("#passwordError");
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            // Add 'is-invalid' class to the element when validation fails
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            // Remove 'is-invalid' class when the element becomes valid
            $(element).removeClass('is-invalid');
            $(element).siblings('.invalid-feedback').remove(); 
        }
    });

    $(function () {
        $("#toggle_pwd").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password").attr("type", type);
            $("#reset_password").attr("type", type);

            if (type === "text") {
                $(this).attr("xlink:href", eyeSvgUrl);
            } else {
                $(this).attr("xlink:href", eyeSvgSlashUrl);

            }
        });

        $("#toggle_conf_pwd").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password_confirm").attr("type", type);
            $("#reset_password_confirm").attr("type", type);

            if (type === "text") {
                $(this).attr("xlink:href", eyeSvgUrl);
            } else {
                $(this).attr("xlink:href", eyeSvgSlashUrl);

            }
        });
    });
    // Confirm password validation

    $('#password_confirmation').on('input', function() {
        var password = $('#password').val();
        var password_confirmation = $(this).val();
        if (password_confirmation === "") {
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmationError').text('Confirm Password is required').show();
        } else if (password !== password_confirmation) {
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmationError').text('Password does not match').show();
        }
        else {
            $('#password_confirmation').removeClass('is-invalid');
            $('#password_confirmationError').text('').hide();
        }
    });


    // Function to validate email format
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
