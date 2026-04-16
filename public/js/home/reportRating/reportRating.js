$(document).ready(function() {
    var charCount = $("#experience").val().length;
    $("#charCount").text(charCount + "/250");

    var maxLength = 250;

    function updateCharCount(textarea) {
        var currentValue = textarea.val().replace(/\r\n/g, '\n');
        var currentLength = currentValue.length;

        if (currentLength <= maxLength) {
            $('#charCount').text(currentLength + '/' + maxLength);
            textarea.removeClass('is-invalid');
            $("#experienceError").text("").hide();
        } else {
            textarea.val(currentValue.substring(0, maxLength));
            $('#charCount').text(maxLength + '/' + maxLength);
        }
    }

    $('#experience').on('input', function() {
        updateCharCount($(this));
    });


    // Listen for form submission
    $('#btnReportRating').click(function(e) {
        // Get the form data
        var experience = $('#experience').val();

        // Clear previous error messages
        $("#experienceError").text('').hide();

        // Check if the experience field is empty
        if (experience === "" || experience.length === 0) {
            $("#experienceError").text("Report is required").show();
            e.preventDefault();
            return false; // Exit the function
        }
    });

    // Close the modal when the close button is clicked
    $('#btnClose').click(function() {
        $('#alertModal').modal('hide');
        setTimeout(function() {
            window.location.href = redirectBackUrl;
        }, 500);
    });

    $('#alertModal').on('hidden.bs.modal', function() {
        setTimeout(function() {
            window.location.href = redirectBackUrl;
        }, 500);
    });

    if(sessionReportRated == true){
        sessionReportRated = false;
        $('#alertModal').modal('show');
    }
});

