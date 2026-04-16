$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    // On page load, check which tab is active and apply styles
    if ($('#active-organizations').hasClass('active')) {
        $('#active-organizations').css('font-size', '16px').css('font-weight', '700');
        $('#pending-approval').css('font-size', '16px').css('font-weight', '400');
    } else if ($('#pending-approval').hasClass('active')) {
        $('#pending-approval').css('font-size', '16px').css('font-weight', '700');
        $('#active-organizations').css('font-size', '16px').css('font-weight', '400');
    }
    // Handle tab click events
    $('#active-organizations').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#active-organizations').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#pending-approval').removeClass('active btn-primarys').addClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '400');
        // Show corresponding tab content
        $('#active-org').addClass('show active').removeClass('fade');
        $('#pending-appro').removeClass('show active').addClass('fade');
    });

    $('#pending-approval').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#pending-approval').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#active-organizations').removeClass('active btn-primarys').addClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '400');
        // Show corresponding tab content
        $('#pending-appro').addClass('show active').removeClass('fade');
        $('#active-org').removeClass('show active').addClass('fade');
    });
});
function wrapTextInColumn(selector, interval) {
    $(selector).each(function () {
        let words = $(this).text().split(' ');
        for (let i = interval; i < words.length; i += interval) {
            words[i] = '<br>' + words[i]; // Add a line break at specified interval
        }
        $(this).html(words.join(' '));
    });
}

// Call the function for your column after the table is drawn
$('#active-organizations-table').on('draw.dt', function () {
    wrapTextInColumn('.address', 4);
    wrapTextInColumn('.country', 3);
    wrapTextInColumn('.name', 2);
});

$('#pending-approval-table').on('draw.dt', function () {
    wrapTextInColumn('.address', 4);
    wrapTextInColumn('.country', 3);
    wrapTextInColumn('.name', 2);
});

$(function () {
    $('#active-organizations').on('click', function () {
        $('#customSearchBox').val('');
        $('#active-organizations-table').DataTable().search('').draw();
        $('#active-organizations-table').DataTable().ajax.reload();

    });

    $('#pending-approval').on('click', function () {
        $('#customSearchBox').val('');
        $('#pending-approval-table').DataTable().search('').draw();
        $('#pending-approval-table').DataTable().ajax.reload();
    });
    // Initialize peer table
    var pendingAapproval = $('#pending-approval-table').DataTable({
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
        ajax: fetchPendingApprovelOrganization,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#pending-approval-table').DataTable().page.info();
                return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
            },
            className: 'fontManage'
        },
        {
            data: 'name',
            name: 'name',
            className: 'fontManage name'
        },
        {
            data: 'status',
            name: 'status',
            className: 'fontManage'
        },
        {
            data: 'country',
            name: 'country',
            className: 'fontManage country'
        },
        {
            data: 'state',
            name: 'state',
            className: 'fontManage'
        },
        {
            data: 'city',
            name: 'city',
            className: 'fontManage'
        },
        {
            data: 'address',
            name: 'address',
            className: 'fontManage address'
        },
        {
            data: 'action',
            name: 'action',
            className: 'rightAlign',
        }
        ],
    });

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

            // Make entire row clickable except for action buttons
            $('#active-organizations-table tbody').on('click', 'tr', function (e) {
                // If the click originated from an action button, stop the propagation
                if (!$(e.target).closest('.btn').length) {
                    var data = api.row(this).data();
                    if (data) {
                        window.location.href = '/admin/organizations/' + data.id; // Navigate to the organization details page
                    }
                }
            });
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
            data: 'name',
            name: 'name',
            className: 'fontManage name'
        },
        {
            data: 'status',
            name: 'status',
            className: 'fontManage'
        },
        {
            data: 'country',
            name: 'country',
            className: 'fontManage country'
        },
        {
            data: 'state',
            name: 'state',
            className: 'fontManage'
        },
        {
            data: 'city',
            name: 'city',
            className: 'fontManage'
        },
        {
            data: 'address',
            name: 'address',
            className: 'fontManage address',
        },
        {
            data: 'ratingtotal',
            name: 'ratingtotal',
            className: 'fontManage'
        },
        {
            data: 'peertotal',
            name: 'peertotal',
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
            if (activeTab === 'pending-appro') {
                pendingAapproval.search(searchValue).draw(); // Apply search to organization table
            } else if (activeTab === 'active-org') {
                activeOrganizations.search(searchValue).draw(); // Apply search to peer table
            }
        }
    });


});

// delete modal for reported comments on Organizations button in the table
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    $('#deleteId').val(id);
    $('#delete').modal('show');

    // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
    $('#confirmDelete').off('click').on('click', function () {
        var id = $('#deleteId').val();
        $.LoadingOverlay("show");

        $.ajax({
            url: 'organizations/delete/' + id,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $('#delete').modal('hide');
                $.LoadingOverlay("hide");
                $('#active-organizations-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();
                toastr.success('Organization has been deleted successfully');
            },
            error: function (xhr) {
                console.log(xhr);
                $('#delete').modal('hide');
                $.LoadingOverlay("hide");
                let errorMessage = xhr.responseJSON?.error || 'Failed to delete the organization. Please try again.';
                toastr.error(errorMessage);
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
        url: 'organizations/' + id,
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
            var id = response.organization.id;
            var name = response.organization.name;
            var countries = response.organization.country;
            var states = response.organization.state;
            var city = response.organization.city;
            var address = response.organization.address;
            var imageUrl = response.organization.image;

            var fullImageUrl = imageUrl ? AWSURL + imageUrl : defaultImage;

            $('#org-logo')
            .attr('src', fullImageUrl)
            .on('error', function () {
                $(this).attr('src', defaultImage);
            });

            $('input[name="organizationName"]').val(name);
            $('input[name="organizationCountry"]').val(countries);
            $('input[name="organizationState"]').val(states);
            $('input[name="organizationCity"]').val(city);
            $('textarea[name="organizationAddress"]').val(address).css('height', 'auto').height(this.scrollHeight);
            $('input[name="organizationId"]').val(id);
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
});
// approve modal for Organizations
$('#confirmApproved').on('click', function () {
    var id = $('#organizationId').val();
    // Ensure the organization ID exists before making the AJAX request
    if (id) {
        //loader show
        $.LoadingOverlay("show");
        $.ajax({
            url: 'organizations/approve/' + id,
            type: 'POST',
            data: {
                _method: 'POST',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                // Hide the modal on success

                $('#view').modal('hide');
                $.LoadingOverlay("hide");
                // Reload DataTables
                $('#active-organizations-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();

                toastr.success('Organization has been approved successfully');
            },
            error: function (xhr) {
                console.log(xhr.responseText);  // Log error details for debugging
            }
        });
    } else {
        console.error('Organization ID is missing');
    }
});


// delete modal for reported comments on organizations
$(document).on('click', '.rejected', function () {

    var organizationId = document.getElementById('organizationId').value;
    // Open the delete modal
    $('#rejects').modal('show');
    // Handle the confirm delete action
    $('#confirmReject').off('click').on('click', function () { // Ensure event handler is attached only once
        var id = organizationId; // Get the correct delete ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'organizations/reject/' + id,
            type: 'POST',
            data: {
                _method: 'POST',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                // Hide all modals after delete
                $('.modal').modal('hide');
                $.LoadingOverlay("hide");
                // Reload DataTables
                $('#active-organizations-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();

                toastr.success('Organization has been rejected successfully');

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
        $('#rejects').css('z-index', highestZIndex + 2); // Set the second modal on top
    }, 200);
});

// Restore interaction with the first modal when the second modal is closed
$('#rejects').on('hidden.bs.modal', function () {
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
