function viewFeedback(id) {

    $.ajax({
        url: `/admin/feedback/show/${id}`,
        type: "GET",
        beforeSend: function () {
            $.LoadingOverlay('show');
        },
        success: function (response) {
            if (response.success == true) {
                $.LoadingOverlay('hide');
                var feedback = response.data;
                $('.feelingVal').text(feedback.feeling.toLowerCase())
                $('.feedbackVal').text(feedback.feedback)
                $('#feelingModal').modal('show');
            } else {
                $.LoadingOverlay('hide');
                toastr.error(response.message)
            }
        },
    });
}

$(document).ready(function () {
    $('.closeBtn').on('click', function () {
        $('#feelingModal').modal('hide')
    });


});

