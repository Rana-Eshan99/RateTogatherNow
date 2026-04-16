document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName("btnStyles");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function(button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function() {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function(button) {
                button.style.background = "#007bff"; // Change color to transparent
                button.style.color = "#fff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function() {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function() {
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

    $('#experience').on('input', function () {
        updateCharCount($(this));
    });

    var emojiImages = {
        'bad': storageBaseUrl + 'img/feedbackIcons/bad.png',
        'somewhat': storageBaseUrl + 'img/feedbackIcons/somewhat.png',
        'neutral': storageBaseUrl + 'img/feedbackIcons/neutral.png',
        'good': storageBaseUrl + 'img/feedbackIcons/good.png',
        'great': storageBaseUrl + 'img/feedbackIcons/great.png',
    };

    $('.emoji-option').click(function () {
        $('.emoji-option').removeClass('active');
        $(this).addClass('active');

        var emojiValue = $(this).data('value');
        if (emojiValue) {
            $('#emojiError').text('').hide();
        }
        var newImageSrc = emojiImages[emojiValue];
        $('.emoji-option').each(function () {
            var value = $(this).data('value');
            $(this).find('img').attr('src', storageBaseUrl + 'img/feedbackIcons/' + value + '_grey.png');
        });

        $(this).find('img').attr('src', newImageSrc);
        $('#feedbackInput').val(emojiValue);
    });

    function getVisitorId() {
        let storedVisitorId = localStorage.getItem('visitorId');

        if (storedVisitorId) {
            console.log('Using stored Visitor ID:', storedVisitorId);
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

                    console.log('Generated new Visitor ID:', visitorId);
                    return visitorId;
                });
        }
    }

    getVisitorId().then(visitorId => {
        console.log('Final Visitor ID:', visitorId);
    });

    $('#btnFeedbackSubmit').click(function (e) {
        e.preventDefault();

        var experience = $('#experience').val();
        var selectedEmoji = $('#feedbackInput').val();
        var token = $('input[name=_token]').val();
        var hasError = false;
        $("#experienceError").text('').hide();

        if (!selectedEmoji) {
            $('#emojiError').text('Emoji selection is required').show();
            hasError = true;
        }

        if (!experience || experience.trim().length === 0) {
            $("#experienceError").text("Enter Description").show();
            hasError = true;
        }

        if (hasError) {
            return;
        }

        // Get the visitor ID and then send the AJAX request
        getVisitorId().then(function(visitorId) {
            // Prepare the form data for AJAX submission
            var formData = {
                feelings: selectedEmoji,
                feedback: experience,
                visitorId: visitorId,  // Include visitor ID here
                _token: token
            };

            $.LoadingOverlay("show");
            $.ajax({
                url: $('#btnFeedbackSubmit').closest('form').attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    $.LoadingOverlay("hide");
                    if (response.response && response.response.status) {
                        $('#alertModal').modal('show');
                    }
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors && errors.experience) {
                        $('#experienceError').text(errors.experience[0]).show();
                    }

                    if (xhr.status == 400 || xhr.status == 500) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });
    });

    $('#btnClose').click(function () {
        $('#alertModal').modal('hide');
        location.reload();
    });

    $('#alertModal').on('hidden.bs.modal', function () {
        location.reload();
    });
});

