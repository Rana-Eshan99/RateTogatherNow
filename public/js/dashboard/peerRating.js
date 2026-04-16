/** Variables */
function setDateTimeLocal(timestamp, format) {
    const localDate = new Date(timestamp * 1000);
    if (format === "date") {
        return moment(timestamp * 1000).format('M-DD-YYYY')
    } else {
        return localDate.toLocaleTimeString("en-US", { hour: "numeric", minute: "numeric", hour12: true });
    }
}

function viewPeerRating(id) {

    $('.boxSpan').html('Yes');
    $('.box').removeClass('red');
    $('.box').addClass('green');
    $('.easyWork').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.dependableWork').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.communicateUnderPressure').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.meetDeadline').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.receivingFeedback').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.respectfullOther').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.assistOther').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.collaborateTeam').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });


     $.ajax({
        url: `/admin/peer-rating/show/${id}`,
        type: "GET",
        beforeSend: function () {
            $.LoadingOverlay('show');
        },
        success: function (response) {
            if (response.success == true) {
                $.LoadingOverlay('hide');
                $('#ratingId').val(id);

                var rating = response.rating;
                $('.rating').text(response.ratingCount);

                $('.longText').text(rating.experience);
                try{
                    Object.keys(rating).map(function (key) {
                        let star = 0;
                        switch (Object.keys(rating).length > 0) {
                            case (response.rating.easyWork > 0 && key == "easyWork"):
                                star = Math.floor(response.rating.easyWork) > 1 ? Math.floor(response.rating.easyWork) : Math.floor(response.rating.easyWork);
                                $('.easyWork').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.workAgain == 0 && key == "workAgain"):
                                $('.boxSpan').html('No');
                                $('.box').removeClass('green');
                                $('.box').addClass('red');
                                break;
                            case (response.rating.dependableWork > 0 && key == "dependableWork"):

                                star = Math.floor(response.rating.dependableWork) > 1 ? Math.floor(response.rating.dependableWork)  : Math.floor(response.rating.dependableWork);
                                $('.dependableWork').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.communicateUnderPressure > 0 && key == "communicateUnderPressure"):

                                star = Math.floor(response.rating.communicateUnderPressure) > 1 ? Math.floor(response.rating.communicateUnderPressure)  : Math.floor(response.rating.communicateUnderPressure);
                                $('.communicateUnderPressure').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.meetDeadline > 0 && key == "meetDeadline"):

                                star = Math.floor(response.rating.meetDeadline) > 1 ? Math.floor(response.rating.meetDeadline)  : Math.floor(response.rating.meetDeadline);
                                $('.meetDeadline').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.receivingFeedback > 0 && key == "receivingFeedback"):

                                star = Math.floor(response.rating.receivingFeedback) > 1 ? Math.floor(response.rating.receivingFeedback)  : Math.floor(response.rating.receivingFeedback);
                                $('.receivingFeedback').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.respectfullOther > 0 && key == "respectfullOther"):
                                star = Math.floor(response.rating.respectfullOther) > 1 ? Math.floor(response.rating.respectfullOther)  : Math.floor(response.rating.respectfullOther);
                                $('.respectfullOther').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.assistOther > 0 && key == "assistOther"):

                                star = Math.floor(response.rating.assistOther) > 1 ? Math.floor(response.rating.assistOther)  : Math.floor(response.rating.assistOther);
                                $('.assistOther').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.collaborateTeam > 0 && key == "collaborateTeam"):

                                star = Math.floor(response.rating.collaborateTeam) > 1 ? Math.floor(response.rating.collaborateTeam)  : Math.floor(response.rating.collaborateTeam);
                                $('.collaborateTeam').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            default:
                                break;

                        }
                    });
                    $('#peerRatingModal').modal('show');
                } catch (error) {
                    console.error('Some thing went wrong:', error.message);
                }
            } else {
                $.LoadingOverlay('hide');
                toastr.error(response.message)
            }
        },
    });
}
$(document).ready(function () {
    $('.closeBtn').on('click', function () {
        $('#peerRatingModal').modal('hide')
    });

    $('#approveBtn').on('click', function () {
        let id = $('#ratingId').val();
        $.ajax({
            url: `/admin/peer-rating/approve/${id}`,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay('show');
            },
            success: function (response) {
                if (response.success == true) {
                    $.LoadingOverlay('hide');

                    toastr.success(response.message)
                    $('#peerRatingModal').modal('hide');
                    $("#peerrating-table").DataTable().ajax.reload();

                }
            }
        });
    });

    $('#rejectBtn').on('click', function () {
        let id = $('#ratingId').val();
        $.ajax({
            url: `/admin/peer-rating/reject/${id}`,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay('show');
            },
            success: function (response) {
                if (response.success == true) {

                    $.LoadingOverlay('hide');

                    toastr.success(response.message)
                    $('#peerRatingModal').modal('hide')
                    $("#peerrating-table").DataTable().ajax.reload();

                }
            }
        });
    });


});

