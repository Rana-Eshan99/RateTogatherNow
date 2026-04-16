$(document).ready(function() {
    $("#signinForms").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            email: {
                required: "Email required.",
                email: "Invalid email format.",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "email") {
                $("#emailError").html('');
                error.appendTo("#emailError");
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            // Add 'is-invalid' class to show the red border
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            // Remove 'is-invalid' class when valid
            $(element).removeClass('is-invalid');
        }
    });

    // Function to validate email format
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
