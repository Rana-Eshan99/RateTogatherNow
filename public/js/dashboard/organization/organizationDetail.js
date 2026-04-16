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

            $('#active-organizations-table tbody').on('click', 'tr', function (e) {
                // If the click originated from an action button, stop the propagation
                if (!$(e.target).closest('.btn').length) {
                    var data = api.row(this).data();
                    if (data) {
                        window.location.href = '/admin/peers/' + data.id + '/ratings'; // Navigate to the organization details page
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
        ajax: fetchOrganizationPeerData,
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
            data: 'firstName',
            name: 'firstName',

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
            className: 'fontManage'
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

    $('#customSearchBox').on('keyup', function (e) {
        var searchValue = this.value.trim();
        var ignoredKeys = [37, 38, 39, 40];

        // Only proceed if the key is not ignored or the input isn't empty
        if (!ignoredKeys.includes(e.keyCode) || searchValue === '') {
                activeOrganizations.search(searchValue).draw(); // Apply search to peer table
        }
    });


});

// delete modal for reported comments on Organizations button in the table
$(document).on('click', '.delete', function () {
    $('#delete').modal('show');
    // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
    $('#confirmDelete').off('click').on('click', function () {
        $.LoadingOverlay("show");
        $.ajax({
            url: organizationDelete,
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $('#delete').modal('hide');
                $.LoadingOverlay("hide");

                //redirect to the page
                window.location.href = '/admin/organizations';

                toastr.success('Organization has been deleted successfully');
            },
            error: function (xhr) {
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


// delete modal for reported comments on Organizations button in the table
$(document).on('click', '.org-peer-delete', function () {
    var id = $(this).data('id');
    $('#deleteIdPeer').val(id);
    $('#org-peer-delete').modal('show');
    // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
    $('#confirmDeletePeer').off('click').on('click', function () {
        var id = $('#deleteIdPeer').val();
        $.LoadingOverlay("show");

        $.ajax({
            url:  organizationId + '/peer/' + id + '/delete',
            type: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('input[name=_token]').val(),
            },
            success: function (response) {
                $('#org-peer-delete').modal('hide');
                $.LoadingOverlay("hide");
                location.reload();
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
