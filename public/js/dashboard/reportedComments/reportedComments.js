$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // On page load, check which tab is active and apply styles
    if ($('#org-reported-comments').hasClass('active')) {
        $('#org-reported-comments').css('font-size', '16px').css('font-weight', '700');
        $('#peer-reported-comments').css('font-size', '16px').css('font-weight', '400');
    } else if ($('#peer-reported-comments').hasClass('active')) {
        $('#peer-reported-comments').css('font-size', '16px').css('font-weight', '700');
        $('#org-reported-comments').css('font-size', '16px').css('font-weight', '400');
    }
    // Handle tab click events
    $('#org-reported-comments').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#org-reported-comments').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#peer-reported-comments').removeClass('active btn-primarys').addClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '400');
        // Show corresponding tab content
        $('#org-reported').addClass('show active').removeClass('fade');
        $('#peer-reported').removeClass('show active').addClass('fade');
    });

    $('#peer-reported-comments').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#peer-reported-comments').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#org-reported-comments').removeClass('active btn-primarys').addClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '400');
        // Show corresponding tab content
        $('#peer-reported').addClass('show active').removeClass('fade');
        $('#org-reported').removeClass('show active').addClass('fade');
    });
});

$(function () {
    $('#org-reported-comments').on('click', function () {
        $('#customSearchBox').val('');
        $('#organizationReports').DataTable().search('').draw();
        $('#organizationReports').DataTable().ajax.reload();

    });
    $('#peer-reported-comments').on('click', function () {
        $('#customSearchBox').val('');
        $('#peerReports').DataTable().search('').draw();
        $('#peerReports').DataTable().ajax.reload();
    });
    // Initialize peer table
    var peerTable = $('#peerReports').DataTable({
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
        processing: true,
        serverSide: true,
        language: {
            'paginate': {
                'previous': '<span class="paginate-btn prev"><<</span>',
                'next': '<span class="paginate-btn next">>></span>'
            }
        },
        "infoCallback": function (settings, start, end, max, total, pre) {
            return 'Showing ' + start + ' to ' + end + ' entries';
        },
        ajax: fetchPeerData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#peerReports').DataTable().page.info();
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
            data: 'peerName',
            name: 'peerName',
            className: 'fontManage'
        },
        {
            data: 'createdAt',
            name: 'createdAt',
            render: function (data, type, row) {
                return moment(data).format('Do MMM, YYYY');
            },
            className: 'fontManage'
        },
        {
            data: 'report',
            name: 'report',
            render: function (data, type, row) {
                var words = data.split(" ");
                return words.length > 5 ? words.slice(0, 5).join(" ") + '...' : data;
            },
            className: 'fontManage'
        },
        {
            data: 'experience',
            name: 'experience',
            render: function (data, type, row) {
                var words = data.split(" ");
                return words.length > 7 ? words.slice(0, 5).join(" ") + '...' : data;
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

    // Initialize organization table
    var organizationTable = $('#organizationReports').DataTable({
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
        ajax: fetchOrganizationData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#organizationReports').DataTable().page.info();
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
                return moment(data).format('Do MMM, YYYY');
            },
            className: 'fontManage'
        },
        {
            data: 'report',
            name: 'report',
            render: function (data, type, row) {
                var words = data.split(" ");
                return words.length > 5 ? words.slice(0, 5).join(" ") + '...' : data;
            },
            className: 'fontManage'
        },
        {
            data: 'experience',
            name: 'experience',
            render: function (data, type, row) {
                var words = data.split(" ");
                return words.length > 7 ? words.slice(0, 5).join(" ") + '...' : data;
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
        var activeTab = $('.tab-content .tab-pane.active').attr('id'); // Get active tab ID
        var searchValue = this.value.trim(); // Trim the search value

        // List of ignored keys (arrows) but still allow backspace (keyCode 8)
        var ignoredKeys = [37, 38, 39, 40];

        // Only proceed if the key is not ignored or the input isn't empty
        if (!ignoredKeys.includes(e.keyCode) || searchValue === '') {
            if (activeTab === 'org-reported') {
                organizationTable.search(searchValue).draw(); // Apply search to organization table
            } else if (activeTab === 'peer-reported') {
                peerTable.search(searchValue).draw(); // Apply search to peer table
            }
        }
    });


});
// delete modal for reported comments on Organizations button in the table
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    $('#deleteId').val(id);
    $('#delete').modal('show');

    $('#confirmDelete').off('click').on('click', function () {
        var id = $('#deleteId').val();
        $.LoadingOverlay("show");
        $.ajax({
            url: 'deleteReportedComments/' + id,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $('#delete').modal('hide');
                $('#organizationReports').DataTable().ajax.reload();
                $('#peerReports').DataTable().ajax.reload();
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    });

    $('#cancelDelete').click(function () {
        $('#delete').modal('hide');
    });
});

// View modal for reported comments on organizations
$(document).on('click', '.view', function () {
    var id = $(this).data('id');
    $.LoadingOverlay("show");
    $.ajax({
        url: 'organization-reported-Comments/' + id,
        type: 'GET',
        data: {
            _method: 'GET',
            _token: $('input[name=_token]').val(),
        },
        success: function (response) {

            $.LoadingOverlay("hide");
            $('#view').modal({
                backdrop: 'static', // Prevents clicking outside the modal to close it
                keyboard: false, // Prevents the 'esc' key from closing the modal
            }).modal('show');
            console.log(response);
            var report = response.success;
            var user = report.user;
            var orgRating = report.organization_rating;
            var organization = orgRating.organization;

            $('#reportedPerson').text(user && user.firstName && user.lastName ?
                user.firstName + ' ' + user.lastName : 'Anonymous');

            $('#report').text(report.report)
            $('#expericeFeedback').text(orgRating.experience);

            $('input[name="careerDevelopmentRating"]').val(orgRating.careerDevelopment);
            $('input[name="companyCultureRating"]').val(orgRating.companyCulture);
            $('input[name="companyReputationRating"]').val(orgRating.companyReputation);
            $('input[name="compensationBenefitRating"]').val(orgRating.compensationBenefit);
            $('input[name="employeeHappynessRating"]').val(orgRating.employeeHappyness);
            $('input[name="growthFuturePlanRating"]').val(orgRating.growthFuturePlan);
            $('input[name="jobStabilityRating"]').val(orgRating.jobStability);
            $('input[name="workLifeBalanceRating"]').val(orgRating.workLifeBalance);
            $('input[name="workplaceDEIRating"]').val(orgRating.workplaceDEI);
            $('input[name="workplaceSSRating"]').val(orgRating.workplaceSS);
            $('input[name="deleteId"]').val(report.id);
            $('input[name="keepId"]').val(report.id);

            $(document).trigger('hiddenFieldsUpdated');
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
});

$(document).on('click', '.view-peer', function () {
    var id = $(this).data('id');
    $.LoadingOverlay("show");
    $.ajax({
        url: 'peer-reported-Comments/' + id,
        type: 'GET',
        data: {
            _method: 'GET',
            _token: $('input[name=_token]').val(),
        },
        success: function (response) {
            $.LoadingOverlay("hide");
            $('#view-peer').modal({
                backdrop: 'static', // Prevents clicking outside the modal to close it
                keyboard: false, // Prevents the 'esc' key from closing the modal
            }).modal('show');

            var peerreport = response.success;
            var peeruser = peerreport.user;
            var peerRating = peerreport.peer_rating;

            var peer = peerRating.peer;

            $('#reportedPersonPeer').text(peeruser && peeruser.firstName && peeruser.lastName ?
                peeruser.firstName + ' ' + peeruser.lastName : 'Anonymous');
            $('#peerReport').text(peerreport.report)
            $('#peerExpericeFeedback').text(peerRating.experience);

            $('input[name="assistOther"]').val(peerRating.assistOther);
            $('input[name="collaborateTeam"]').val(peerRating.collaborateTeam);
            $('input[name="communicateUnderPressure"]').val(peerRating.communicateUnderPressure);
            $('input[name="dependableWork"]').val(peerRating.dependableWork);
            $('input[name="easyWork"]').val(peerRating.easyWork);
            $('input[name="meetDeadline"]').val(peerRating.meetDeadline);
            $('input[name="receivingFeedback"]').val(peerRating.receivingFeedback);
            $('input[name="respectfullOther"]').val(peerRating.respectfullOther);
            $('input[name="workAgain"]').val(peerRating.workAgain);
            $('input[name="deleteIdPeer"]').val(peerreport.id);
            $('input[name="keepIdPeer"]').val(peerreport.id);


            $(document).trigger('hiddenFieldsUpdated');
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
});
// delete modal for reported comments on organizations
$(document).on('click', '.delete-peer-btn', function () {
    // Get the delete ID from the hidden input
    var peerDeleteId = document.getElementById('deleteIdPeer').value;
    document.getElementById('deleteIdPeer2').value = deleteId;
    // Open the delete modal
    $('#delete').modal('show');

    // Handle the confirm delete action
    $('#confirmDelete').off('click').on('click', function () { // Ensure event handler is attached only once
        var peerid = peerDeleteId; // Get the correct delete ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'deletePeerReportedComments/' + peerid,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                // Hide all modals after delete
                $.LoadingOverlay("hide");
                $('.modal').modal('hide');

                // Reload DataTables
                $('#organizationReports').DataTable().ajax.reload();
                $('#peerReports').DataTable().ajax.reload();

                // Reset modal and backdrop z-index after all modals are hidden
                $(document).on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    });

    // Ensure the second modal appears on top of the first one
    setTimeout(function () {
        var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
            parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(
                zIndex))) || 1050;

        // Adjust backdrop and second modal z-index
        $('.modal-backdrop').not('.modal-stack').css('z-index', highestZIndex + 1).addClass(
            'modal-stack');
        $('#delete').css('z-index', highestZIndex + 2); // Set the second modal on top
    }, 200);
});

// Restore interaction with the first modal when the second modal is closed
$('#delete').on('hidden.bs.modal', function () {
    var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
        parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(zIndex))) || 1050;

    $('#view-peer').css('z-index', highestZIndex + 1);
});

// Optional: Ensure body and backdrop are cleaned up when all modals are hidden
$(document).on('hidden.bs.modal', function () {
    if ($('.modal:visible').length === 0) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
});

// delete modal for reported comments on organizations
$(document).on('click', '.delete-btn', function () {
    // Get the delete ID from the hidden input
    var deleteId = document.getElementById('deleteId').value;
    document.getElementById('deleteId1').value = deleteId;

    // Open the delete modal
    $('#delete').modal('show');

    // Handle the confirm delete action
    $('#confirmDelete').off('click').on('click', function () { // Ensure event handler is attached only once
        var id = deleteId; // Get the correct delete ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'deleteReportedComments/' + id,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                // Hide all modals after delete
                $('.modal').modal('hide');

                // Reload DataTables
                $('#organizationReports').DataTable().ajax.reload();
                $('#peerReports').DataTable().ajax.reload();

                // Reset modal and backdrop z-index after all modals are hidden
                $(document).on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    });

    // Ensure the second modal appears on top of the first one
    setTimeout(function () {
        var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
            parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(
                zIndex))) || 1050;

        // Adjust backdrop and second modal z-index
        $('.modal-backdrop').not('.modal-stack').css('z-index', highestZIndex + 1).addClass(
            'modal-stack');
        $('#delete').css('z-index', highestZIndex + 2); // Set the second modal on top
    }, 200);
});

// Restore interaction with the first modal when the second modal is closed
$('#delete').on('hidden.bs.modal', function () {
    var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
        parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(zIndex))) || 1050;

    $('#view').css('z-index', highestZIndex + 1);
});

// Optional: Ensure body and backdrop are cleaned up when all modals are hidden
$(document).on('hidden.bs.modal', function () {
    if ($('.modal:visible').length === 0) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
});


// keep modal for reported comments on organizations
$(document).on('click', '.keep-btn', function () {
    // Get the keep ID from the hidden input
    var keepId = document.getElementById('keepId').value;
    document.getElementById('keepId1').value = keepId;

    // Open the keep modal
    $('#keep').modal('show');

    // Handle the confirm keep action
    $('#confirmKeep').off('click').on('click', function () { // Ensure event handler is attached only once
        var id = keepId; // Get the correct keep ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'keep-organization-reported-comment/' + id,
            type: 'POST',
            data: {
                _method: 'POST',
                _token: $('input[name=_token]').val(),
                keepId: $('#keepId').val(),
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                // Hide all modals after keep
                $('.modal').modal('hide');

                // Reload DataTables
                $('#organizationReports').DataTable().ajax.reload();
                $('#peerReports').DataTable().ajax.reload();

                // Reset modal and backdrop z-index after all modals are hidden
                $(document).on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    });

    // Ensure the second modal appears on top of the first one
    setTimeout(function () {
        var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
            parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(
                zIndex))) || 1050;

        // Adjust backdrop and second modal z-index
        $('.modal-backdrop').not('.modal-stack').css('z-index', highestZIndex + 1).addClass(
            'modal-stack');
        $('#keep').css('z-index', highestZIndex + 2); // Set the second modal on top
    }, 200);
});

// Restore interaction with the first modal when the second modal is closed
$('#keep').on('hidden.bs.modal', function () {
    var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
        parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(zIndex))) || 1050;

    $('#view').css('z-index', highestZIndex + 1);
});

// Optional: Ensure body and backdrop are cleaned up when all modals are hidden
$(document).on('hidden.bs.modal', function () {
    if ($('.modal:visible').length === 0) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
});

// keep modal for reported comments on peers
$(document).on('click', '.keep-peers-btn', function () {
    // Get the keep ID from the hidden input
    var keepPeerId = document.getElementById('keepIdPeer').value;
    document.getElementById('keepIdPeer2').value = keepPeerId;

    // Open the keep modal
    $('#keep-peers').modal('show');

    // Handle the confirm keep action
    $('#confirmKeepPeer').off('click').on('click', function () { // Ensure event handler is attached only once
        var id = keepId; // Get the correct keep ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'keep-peer-reported-comment/' + id,
            type: 'POST',
            data: {
                _method: 'POST',
                _token: $('input[name=_token]').val(),
                keepPeerId: $('#keepIdPeer').val(),
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                // Hide all modals after keep
                $('.modal').modal('hide');

                // Reload DataTables
                $('#organizationReports').DataTable().ajax.reload();
                $('#peerReports').DataTable().ajax.reload();

                // Reset modal and backdrop z-index after all modals are hidden
                $(document).on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    });

    // Ensure the second modal appears on top of the first one
    setTimeout(function () {
        var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
            parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(
                zIndex))) || 1050;

        // Adjust backdrop and second modal z-index
        $('.modal-backdrop').not('.modal-stack').css('z-index', highestZIndex + 1).addClass(
            'modal-stack');
        $('#keep-peers').css('z-index', highestZIndex + 2); // Set the second modal on top
    }, 200);
});

// Restore interaction with the first modal when the second modal is closed
$('#keep-peers').on('hidden.bs.modal', function () {
    var highestZIndex = Math.max(...Array.from(document.querySelectorAll('*')).map(el =>
        parseFloat(window.getComputedStyle(el).zIndex)).filter(zIndex => !isNaN(zIndex))) || 1050;

    $('#view-peer').css('z-index', highestZIndex + 1);
});

// Optional: Ensure body and backdrop are cleaned up when all modals are hidden
$(document).on('hidden.bs.modal', function () {
    if ($('.modal:visible').length === 0) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    }
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

        // get the delete id and set it in the hidden input
        var deleteId = document.getElementById('deleteId').value;
        document.getElementById('deleteId1').value = deleteId;

        var assistOther = parseFloat(document.getElementById('assistOther').value) || 0;
        var container = document.getElementById('assistOtherContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = assistOther >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var collaborateTeam = parseFloat(document.getElementById('collaborateTeam').value) || 0;
        var container = document.getElementById('collaborateTeamContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = collaborateTeam >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var communicateUnderPressure = parseFloat(document.getElementById('communicateUnderPressure').value) || 0;
        var container = document.getElementById('communicateUnderPressureContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = communicateUnderPressure >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var dependableWork = parseFloat(document.getElementById('dependableWork').value) || 0;
        var container = document.getElementById('dependableWorkContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = dependableWork >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var easyWork = parseFloat(document.getElementById('easyWork').value) || 0;
        var container = document.getElementById('easyWorkContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = easyWork >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var meetDeadline = parseFloat(document.getElementById('meetDeadline').value) || 0;
        var container = document.getElementById('meetDeadlineContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = meetDeadline >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var receivingFeedback = parseFloat(document.getElementById('receivingFeedback').value) || 0;
        var container = document.getElementById('receivingFeedbackContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = receivingFeedback >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var respectfullOther = parseFloat(document.getElementById('respectfullOther').value) || 0;
        var container = document.getElementById('respectfullOtherContainer');
        container.innerHTML = ''; // Clear existing stars
        for (var i = 1; i <= 5; i++) {
            var starClass = respectfullOther >= i ? 'filled' : '';
            var starSpan = document.createElement('span');
            starSpan.className = 'star user-star-rating ' + starClass;
            starSpan.innerHTML = '&#9733;';
            container.appendChild(starSpan);
        }

        var workAgain = parseFloat(document.getElementById('workAgain').value) || 0;
        var container = document.getElementById('workAgainContainer');
        container.innerHTML = ''; // Clear existing content

        var color = workAgain == 1 ? '#11951E' : '#FF0000';
        var statusText = workAgain == 1 ? 'Yes' : 'No';

        var starDiv = document.createElement('div');
        starDiv.style.width = '23px';
        starDiv.style.height = '23px';
        starDiv.style.backgroundColor = color;
        starDiv.style.borderRadius = '3px';
        starDiv.style.marginRight = '8px'; // Adds some space between the icon and text

        var textSpan = document.createElement('span');
        textSpan.className = 'work-again';
        textSpan.innerText = statusText;

        container.appendChild(starDiv);
        container.appendChild(textSpan);

        // now find % of all

        var total = assistOther + collaborateTeam + communicateUnderPressure + dependableWork + easyWork + meetDeadline + receivingFeedback + respectfullOther;
        var totalPercentage = (total / 8);
        document.getElementById('points-peer').innerHTML = totalPercentage.toFixed(1);



    }
    // Trigger the update when the custom event is fired
    $(document).on('hiddenFieldsUpdated', function () {
        updateStarRatings();
    });
    updateStarRatings();
});
