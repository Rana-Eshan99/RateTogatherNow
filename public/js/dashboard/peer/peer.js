$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // On page load, check which tab is active and apply styles
    if ($('#active-peers').hasClass('active')) {
        $('#active-peers').css('font-size', '16px').css('font-weight', '700');
        $('#pending-approval').css('font-size', '16px').css('font-weight', '400');
    } else if ($('#pending-approval').hasClass('active')) {
        $('#pending-approval').css('font-size', '16px').css('font-weight', '700');
        $('#active-peers').css('font-size', '16px').css('font-weight', '400');
    }

    // Handle tab click events
    $('#active-peers').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#active-peers').addClass('active btn-primarys').removeClass('text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#pending-approval').removeClass('active btn-primarys').addClass('text-dark btn-link').css('font-size', '16px').css('font-weight', '400');

        // Show corresponding tab content
        $('#active-peer').addClass('show active').removeClass('fade');
        $('#pending-appro').removeClass('show active').addClass('fade');

        $('#organization').val(null).trigger('change');  // Reset organization select
        $('#department').val(null).trigger('change');
        // Check if the table exists before reloading
        if ($.fn.DataTable.isDataTable('#active-peers-table')) {
            $('#active-peers-table').DataTable().ajax.reload();
        }
    });

    $('#pending-approval').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#pending-approval').addClass('active btn-primarys').removeClass('text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#active-peers').removeClass('active btn-primarys').addClass('text-dark btn-link').css('font-size', '16px').css('font-weight', '400');

        // Show corresponding tab content
        $('#pending-appro').addClass('show active').removeClass('fade');
        $('#active-peer').removeClass('show active').addClass('fade');

        $('#organization').val(null).trigger('change');  // Reset organization select
        $('#department').val(null).trigger('change');

        // Check if the table exists before reloading
        if ($.fn.DataTable.isDataTable('#pending-approval-table')) {
            $('#pending-approval-table').DataTable().ajax.reload();
        }
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
$('#active-peers-table').on('draw.dt', function () {
    wrapTextInColumn('.jobTitle', 3);
});

$('#pending-approval-table').on('draw.dt', function () {
    wrapTextInColumn('.jobTitle', 3);
});

$(function () {
    // Initialize DataTables only if the table is present in the DOM
    if ($('#active-peers-table').length) {
        var activePeers = $('#active-peers-table').DataTable({
            paging: true,
            lengthChange: false,
            ordering: false,
            info: true,
            autoWidth: false,
            dom: '<"top">rt<"bottom"ilp><"clear">',
            drawCallback: function (settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages >= 1) {
                    pagination.show();
                } else {
                    pagination.hide();
                }


                $('#active-peers-table tbody').on('click', 'tr', function (e) {
                    // If the click originated from an action button, stop the propagation
                    if (!$(e.target).closest('.btn').length) {
                        var data = api.row(this).data();
                        if (data) {
                            window.location.href = 'peers/' + data.id + '/ratings'; // Navigate to the organization details page
                        }
                    }
                });
            },
            language: {
                paginate: {
                    previous: '<span class="paginate-btn prev"><<</span>',
                    next: '<span class="paginate-btn next">>></span>'
                }
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return 'Showing ' + start + ' to ' + end + ' entries';
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: fetchActiveOrganizationsData,
                data: function (d) {
                    d.organization = $('#organization').val();
                    d.department = $('#department').val();
                    return d;
                }
            },
            columns: [{
                data: 'id',
                name: 'id',
                render: function (data, type, row, meta) {
                    // Calculate the continuous row number by adding the page offset
                    var pageInfo = $('#active-peers-table').DataTable().page.info();
                    return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
                },
                className: 'fontManage'
            },
            {
                data: 'peerName',
                name: 'peerName',
                className: 'fontManage'
            },
            {
                data: 'status',
                name: 'status',
                className: 'fontManage'
            },
            {
                data: 'organizationName',
                name: 'organizationName',
                className: 'fontManage'
            },
            {
                data: 'departmentName',
                name: 'departmentName',
                className: 'fontManage'
            },
            {
                data: 'jobTitle',
                name: 'jobTitle',
                className: 'fontManage jobTitle'
            },
            {
                data: 'ratingtotal',
                name: 'ratingtotal',
                className: 'fontManage'
            },
            {
                data: 'action',
                name: 'action',
                className: 'rightAlign',
            }
            ],
        });
    }

    if ($('#pending-approval-table').length) {
        var pendingApproval = $('#pending-approval-table').DataTable({
            paging: true,
            lengthChange: false,
            ordering: false,
            info: true,
            autoWidth: false,
            dom: '<"top">rt<"bottom"ilp><"clear">',
            drawCallback: function (settings) {
                var api = this.api();
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                if (api.page.info().pages >= 1) {
                    pagination.show();
                } else {
                    pagination.hide();
                }
            },
            language: {
                paginate: {
                    previous: '<span class="paginate-btn prev"><<</span>',
                    next: '<span class="paginate-btn next">>></span>'
                }
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return 'Showing ' + start + ' to ' + end + ' entries';
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: fetchPendingApprovelOrganization,
                data: function (d) {
                    d.organization = $('#organization').val();
                    d.department = $('#department').val();
                    return d;
                }
            },
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
                data: 'firstName',
            name: 'firstName',
                className: 'fontManage'
            },
            {
                data: 'status',
                name: 'status',
                className: 'fontManage'
            },
            {
                data: 'organizationName',
                name: 'organizationName',
                className: 'fontManage'
            },
            {
                data: 'departmentName',
                name: 'departmentName',
                className: 'fontManage'
            },
            {
                data: 'jobTitle',
                name: 'jobTitle',
                className: 'fontManage jobTitle'
            },
            {
                data: 'action',
                name: 'action',
                className: 'rightAlign',
            }
            ],
        });
    }

    // Filter logic on organization and department change
    $("#organization, #department").change(function () {
        var activeTabId = $('.tab-content .tab-pane.show.active').attr('id');
        if (activeTabId === 'active-peer' && $.fn.DataTable.isDataTable('#active-peers-table')) {
            $('#active-peers-table').DataTable().ajax.reload();
        } else if (activeTabId === 'pending-appro' && $.fn.DataTable.isDataTable('#pending-approval-table')) {
            $('#pending-approval-table').DataTable().ajax.reload();
        }
    });

    $('#customSearchBox').on('keyup', function (e) {
        var activeTab = $('.tab-content .tab-pane.active').attr('id'); // Get active tab ID
        var searchValue = this.value.trim(); // Trim the search value

        // List of ignored keys (arrows) but still allow backspace (keyCode 8)
        var ignoredKeys = [37, 38, 39, 40];

        // Only proceed if the key is not ignored or the input isn't empty
        if (!ignoredKeys.includes(e.keyCode) || searchValue === '') {
            if (activeTab === 'pending-appro' && $.fn.DataTable.isDataTable('#pending-approval-table')) {
                pendingApproval.search(searchValue).draw(); // Apply search to pending approval table
            } else if (activeTab === 'active-peer' && $.fn.DataTable.isDataTable('#active-peers-table')) {
                activePeers.search(searchValue).draw(); // Apply search to active organizations table
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
            url: 'peers/delete/' + id,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $('#delete').modal('hide');
                $.LoadingOverlay("hide");
                $('#active-peers-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();
                toastr.success("Peer has been deleted successfully");
            },
            error: function (xhr) {
                console.log(xhr);
                $.LoadingOverlay("hide"); // Hide the loader even if there's an error
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
        url: 'peers/' + id,
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
            var id = response.peer.id;
            var name = response.peer.firstName + ' ' + response.peer.lastName;
            var peerOrganization = response.peer.organization.name;
            var peerDepartment = response.peer.department.name;
            var peerJobTitle = response.peer.jobTitle;


            $('input[name="PeerName"]').val(name);
            $('input[name="PeerId"]').val(id);
            $('input[name="PeerOrganization"]').val(peerOrganization);
            $('input[name="PeerDepartment"]').val(peerDepartment);
            $('input[name="PeerJobTitle"]').val(peerJobTitle);

        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
});
// approve modal for Organizations
$('#confirmApproved').on('click', function () {
    var id = $('#PeerId').val();
    // Ensure the organization ID exists before making the AJAX request
    if (id) {
         //loader show
    $.LoadingOverlay("show");
        $.ajax({
            url: 'peers/approve/' + id,
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
                $('#active-peers-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();
                toastr.success("Peer has been approved successfully");
            },
            error: function (xhr) {
                console.log(xhr.responseText);  // Log error details for debugging
            }
        });
    } else {
        console.error('Peer ID is missing');
    }
});


// delete modal for reported comments on organizations
$(document).on('click', '.rejected', function () {

    var organizationId = document.getElementById('PeerId').value;
    // Open the delete modal
    $('#rejects').modal('show');
    // Handle the confirm delete action
    $('#confirmReject').off('click').on('click', function () { // Ensure event handler is attached only once
        var id = organizationId; // Get the correct delete ID
        $.LoadingOverlay("show");
        $.ajax({
            url: 'peers/reject/' + id,
            type: 'POST',
            data: {
                _method: 'POST',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                // Hide all modals after delete
                $('.modal').modal('hide');

                // Reload DataTables
                $('#active-peers-table').DataTable().ajax.reload();
                $('#pending-approval-table').DataTable().ajax.reload();
                toastr.success("Peer has been rejected successfully");

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
$(document).ready(function () {
    // Select2 initialization and handling
    $("#organization").select2({
        placeholder: 'All Organizations',
        width: '100%'
    });

    $('#organization').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    $("#department").select2({
        placeholder: 'All Departments',
        width: '100%'
    });

    $('#department').on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    // Trigger DataTable reload on organization change
    $("#organization").change(function (e) {
        let organizationId = $("#organization").val();
        var $departmentSelectBox = $('#department');

        // Clear and reset the department select box
        $departmentSelectBox.empty();
        $departmentSelectBox.append('<option value="" selected disabled>Select Department</option>');

        // Check if organizationId is '-1', indicating "All Organizations"
        if (organizationId === "-1") {
            // Reset the organization and department select values
            $('#organization').val(null).trigger('change.select2');  // Reset organization select
            $departmentSelectBox.val(null).trigger('change.select2'); // Reset department select

            // Reload the DataTable to show all organizations
            if ($.fn.DataTable.isDataTable('#active-peers-table')) {
                $('#active-peers-table').DataTable().ajax.reload();
            }

            if ($.fn.DataTable.isDataTable('#pending-approval-table')) {
                $('#pending-approval-table').DataTable().ajax.reload();
            }

            // Stop further execution since '-1' means reset
            return;
        }

        // Proceed with fetching departments if organizationId is valid and not '-1'
        if (organizationId) {
            $.ajax({
                type: "GET",
                url: "/department/get-departments/" + organizationId,
                success: function (response) {

                    if (response.response.status) {
                        // Populate the department select box with the received departments
                        $.each(response.response.departments, function (index, department) {
                            $departmentSelectBox.append('<option value="' + department.id + '">' + department.name + '</option>');
                        });

                        $departmentSelectBox.select2({ placeholder: 'Select department', width: '100%' });
                    }

                    // Reload DataTable after organization change
                    if ($.fn.DataTable.isDataTable('#active-peers-table')) {
                        $('#active-peers-table').DataTable().ajax.reload();
                    }
                },
                error: function (xhr) {
                    $.LoadingOverlay("hide");
                    toastr.error(xhr.responseJSON.message || "An error occurred while fetching departments.");
                }
            });
        } else {
            $("#organizationError").html("Organization required").show();
        }
    });


    // Trigger DataTable reload on department change
    $("#department").change(function () {
        if ($.fn.DataTable.isDataTable('#active-peers-table')) {
            $('#active-peers-table').DataTable().ajax.reload();
        }
    });
});
