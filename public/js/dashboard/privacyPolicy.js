$("#createPrivacyPolicy").validate({
    submitHandler: function (form) {
        $.ajax({
            type: "POST",
            url: `/admin/privacy-policy`,
            data: $(form).serialize(),
            cache: false,
            processData: false,
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                if (response.success == true) {
                    toastr.success(response.message)
                    setTimeout(function () {
                    }, 1000);
                    if (response.redirectUrl) {
                        window.location.href = response.redirectUrl;
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                $.LoadingOverlay("hide");
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.description) {
                        toastr.error(errors.description[0]);
                    } else {
                        toastr.error("An error occurred while processing the form.");
                    }
                } else {
                    toastr.error("An error occurred while processing the form.");
                }
            }
        });
    },
});
