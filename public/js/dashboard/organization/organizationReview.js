$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    // Initialize organization table
    var activeOrganizations = $('#active-organizations-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "dom": '<"top">rt<"bottom"ilp><"clear">',
        "drawCallback": function (settings) {
            var api = this.api();
            var pagination = $(this).closest('.dataTables_wrapper').find(
                '.dataTables_paginate');
            if (api.page.info().pages >= 1) {
                pagination.show();
            } else {
                pagination.hide();
            }
        },
        language: {
            'paginate': {
                'previous': '<span class="paginate-btn prev"><<</span>',
                'next': '<span class="paginate-btn next">>></span>'
            }
        },
        "infoCallback": function (settings, start, end, max, total, pre) {
            return 'Showing ' + start + ' to ' + end + ' entries';
        },
        processing: true,
        serverSide: true,
        ajax: fetchActiveOrganizationsData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#active-organizations-table').DataTable().page.info();
                return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
            },
            className: 'fontManage'
        },
        {
            data: 'userName',
            name: 'userName',

            className: 'fontManage'
        },
        {
            data: 'organizationName',
            name: 'organizationName',
            className: 'fontManage'
        },
        {
            data: 'createdAt',
            name: 'createdAt',
            render: function (data, type, row) {
                return moment(data).format('M-DD-YYYY'); // Format the date as month-day-year
            },
            className: 'fontManage'
        },
        {
            data: 'ratingTotal',
            name: 'ratingTotal',
            className: 'fontManage'
        },
        {
            data: 'experience',
            name: 'experience',
            render: function (data, type, row) {
                var words = data.split(" ");
                return words.length > 5 ? words.slice(0, 5).join(" ") + '...' : data;
            },
            className: 'fontManage'
        },
        {
            data: 'action',
            name: 'action',
            className: 'rightAlign',
        }
        ],
    });

    $('#customSearchBox').on('keyup', function (e) {
        var searchValue = this.value.trim();
        var ignoredKeys = [37, 38, 39, 40];

        // Only proceed if the key is not ignored or the input isn't empty
        if (!ignoredKeys.includes(e.keyCode) || searchValue === '') {
                activeOrganizations.search(searchValue).draw(); // Apply search to peer table
        }
    });


});

// View modal for reported comments on organizations
$(document).on('click', '.view', function () {
    var id = $(this).data('id');
    $.LoadingOverlay("show");
    $.ajax({
        url: '/admin/organizations/reviews/' + id,
        type: 'GET',
        data: {
            id: id,
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            $('#view').modal({
                backdrop: 'static', // Prevents clicking outside the modal to close it
                keyboard: false, // Prevents the 'esc' key from closing the modal
            }).modal('show');

            $('#expericeFeedback').text(response.organization[0].experience);
            $('input[name="careerDevelopmentRating"]').val(response.organization[0].careerDevelopment);
            $('input[name="companyCultureRating"]').val(response.organization[0].companyCulture);
            $('input[name="companyReputationRating"]').val(response.organization[0].companyReputation);
            $('input[name="compensationBenefitRating"]').val(response.organization[0].compensationBenefit);
            $('input[name="employeeHappynessRating"]').val(response.organization[0].employeeHappyness);
            $('input[name="growthFuturePlanRating"]').val(response.organization[0].growthFuturePlan);
            $('input[name="jobStabilityRating"]').val(response.organization[0].jobStability);
            $('input[name="workLifeBalanceRating"]').val(response.organization[0].workLifeBalance);
            $('input[name="workplaceDEIRating"]').val(response.organization[0].workplaceDEI);
            $('input[name="workplaceSSRating"]').val(response.organization[0].workplaceSS);

            $(document).trigger('hiddenFieldsUpdated');
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Function to update star ratings
    function updateStarRatings() {

        var careerDevelopmentRating = parseFloat(document.getElementById('careerDevelopmentRating').value) || 0;
        var container = document.getElementById('careerDevelopmentRatingContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = careerDevelopmentRating >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var companyCultureRating = parseFloat(document.getElementById('companyCultureRating').value) || 0;
        var container = document.getElementById('companyCultureRatingContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = companyCultureRating >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var companyReputationRating = parseFloat(document.getElementById('companyReputationRating').value) || 0;
        var container = document.getElementById('companyReputationRatingContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = companyReputationRating >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var compensationBenefitRating = parseFloat(document.getElementById('compensationBenefitRating').value) || 0;
        var container = document.getElementById('compensationBenefitRatingContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = compensationBenefitRating >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var employeeHappynessRating = parseFloat(document.getElementById('employeeHappynessRating').value) || 0;
        var container = document.getElementById('employeeHappynessRatingContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = employeeHappynessRating >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var growthFuturePlan = parseFloat(document.getElementById('growthFuturePlanRating').value) || 0;
        var container = document.getElementById('growthFuturePlanContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = growthFuturePlan >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var jobStability = parseFloat(document.getElementById('jobStabilityRating').value) || 0;
        var container = document.getElementById('jobStabilityContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = jobStability >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var workLifeBalance = parseFloat(document.getElementById('workLifeBalanceRating').value) || 0;
        var container = document.getElementById('workLifeBalanceContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = workLifeBalance >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var workplaceDEI = parseFloat(document.getElementById('workplaceDEIRating').value) || 0;
        var container = document.getElementById('workplaceDEIContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = workplaceDEI >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var workplaceSS = parseFloat(document.getElementById('workplaceSSRating').value) || 0;
        var container = document.getElementById('workplaceSSContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = workplaceSS >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        //now find % of all

        var total = careerDevelopmentRating + companyCultureRating + companyReputationRating + compensationBenefitRating + employeeHappynessRating + growthFuturePlan + jobStability + workLifeBalance + workplaceDEI + workplaceSS;
        var totalPercentage = (total / 10);
        document.getElementById('points').innerHTML = totalPercentage.toFixed(1);


    }
    // Trigger the update when the custom event is fired
    $(document).on('hiddenFieldsUpdated', function () {
        updateStarRatings();
    });
    updateStarRatings();
});
