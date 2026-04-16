

/** Variables */
function setDateTimeLocal(timestamp, format) {
    const localDate = new Date(timestamp * 1000);
    if (format === "date") {
        return moment(timestamp * 1000).format('M-DD-YYYY')

    } else {
        return localDate.toLocaleTimeString("en-US", { hour: "numeric", minute: "numeric", hour12: true });
    }
}
function viewOrganizationRating(id) {
    $('.company-culture').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.employee-happiness').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.career-development').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.work-life').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.compensation-benefits').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.job-stability').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.workplace-diversity').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.company-reputation').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.workplace-safety').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });
    $('.company-growth').find(`img:lt(5)`).each(function (item, element) {
        $(element).attr('src', '/img/star.svg')
    });


    $.ajax({
        url: `/admin/organization-rating/show/${id}`,
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
                try {
                    Object.keys(rating).map(function (key) {
                        let star = 0;
                        switch (Object.keys(rating).length > 0) {
                            case (response.rating.companyCulture > 0 && key == "companyCulture"):
                                star = Math.floor(response.rating.companyCulture) > 1 ? Math.floor(response.rating.companyCulture)  : Math.floor(response.rating.companyCulture);
                                $('.company-culture').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.employeeHappyness > 0 && key == "employeeHappyness"):

                                star = Math.floor(response.rating.employeeHappyness) > 1 ? Math.floor(response.rating.employeeHappyness)  : Math.floor(response.rating.employeeHappyness);
                                $('.employee-happiness').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.careerDevelopment > 0 && key == "careerDevelopment"):

                                star = Math.floor(response.rating.careerDevelopment) > 1 ? Math.floor(response.rating.careerDevelopment)  : Math.floor(response.rating.careerDevelopment);
                                $('.career-development').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.workLifeBalance > 0 && key == "workLifeBalance"):

                                star = Math.floor(response.rating.workLifeBalance) > 1 ? Math.floor(response.rating.workLifeBalance)  : Math.floor(response.rating.workLifeBalance);
                                $('.work-life').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.compensationBenefit > 0 && key == "compensationBenefit"):

                                star = Math.floor(response.rating.compensationBenefit) > 1 ? Math.floor(response.rating.compensationBenefit)  : Math.floor(response.rating.compensationBenefit);
                                $('.compensation-benefits').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.jobStability > 0 && key == "jobStability"):

                                star = Math.floor(response.rating.jobStability) > 1 ? Math.floor(response.rating.jobStability)  : Math.floor(response.rating.jobStability);
                                $('.job-stability').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.workplaceDEI > 0 && key == "workplaceDEI"):
                                star = Math.floor(response.rating.workplaceDEI) > 1 ? Math.floor(response.rating.workplaceDEI)  : Math.floor(response.rating.workplaceDEI);
                                $('.workplace-diversity').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.companyReputation > 0 && key == "companyReputation"):

                                star = Math.floor(response.rating.companyReputation) > 1 ? Math.floor(response.rating.companyReputation)  : Math.floor(response.rating.companyReputation);
                                $('.company-reputation').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.workplaceSS > 0 && key == "workplaceSS"):

                                star = Math.floor(response.rating.workplaceSS) > 1 ? Math.floor(response.rating.workplaceSS)  : Math.floor(response.rating.workplaceSS);
                                $('.workplace-safety').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            case (response.rating.growthFuturePlan > 0 && key == "growthFuturePlan"):
                                star = Math.floor(response.rating.growthFuturePlan) > 1 ? Math.floor(response.rating.growthFuturePlan)  : Math.floor(response.rating.growthFuturePlan);
                                $('.company-growth').find(`img:lt(${star})`).each(function (item, element) {
                                    $(element).attr('src', '/img/starFilled.svg')
                                });
                                break;
                            default:
                                break;

                        }
                    });
                    $('#organizationRatingModal').modal('show');
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
        $('#organizationRatingModal').modal('hide')
    });

    $('#approveBtn').on('click', function () {
        let id = $('#ratingId').val();
        $.ajax({
            url: `/admin/organization-rating/approve/${id}`,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay('show');
            },
            success: function (response) {
                if (response.success == true) {
                    $.LoadingOverlay('hide');
                    toastr.success(response.message)
                    $('#organizationRatingModal').modal('hide')
                    $('#organizationrating-table').DataTable().ajax.reload();
                }
            }
        });
    });

    $('#rejectBtn').on('click', function () {
        let id = $('#ratingId').val();
        $.ajax({
            url: `/admin/organization-rating/reject/${id}`,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            beforeSend: function () {
                $.LoadingOverlay('show');
            },
            success: function (response) {
                if (response.success == true) {
                    $.LoadingOverlay('hide');
                    toastr.success(response.message)
                     $('#organizationRatingModal').modal('hide')
                     $('#organizationrating-table').DataTable().ajax.reload();

                }
            }
        });
    });

});
