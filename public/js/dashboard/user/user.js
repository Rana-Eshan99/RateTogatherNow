$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    // On page load, check which tab is active and apply styles
    if ($('#active-user').hasClass('active')) {
        $('#active-user').css('font-size', '16px').css('font-weight', '700');
        $('#block-user').css('font-size', '16px').css('font-weight', '400');
    } else if ($('#block-user').hasClass('active')) {
        $('#block-user').css('font-size', '16px').css('font-weight', '700');
        $('#active-user').css('font-size', '16px').css('font-weight', '400');
    }
    // Handle tab click events
    $('#active-user').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#active-user').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#block-user').removeClass('active btn-primarys').addClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '400');
        // Show corresponding tab content
        $('#active-org').addClass('show active').removeClass('fade');
        $('#pending-appro').removeClass('show active').addClass('fade');
    });

    $('#block-user').click(function (e) {
        e.preventDefault();
        // Switch active class on tabs
        $('#block-user').addClass('active btn-primarys').removeClass(
            'text-dark btn-link').css('font-size', '16px').css('font-weight', '700');
        $('#active-user').removeClass('active btn-primarys').addClass(
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
$('#active-user-table').on('draw.dt', function () {
    wrapTextInColumn('.address', 4);
    wrapTextInColumn('.country', 3);
    wrapTextInColumn('.name', 2);
});

$('#block-user-table').on('draw.dt', function () {
    wrapTextInColumn('.address', 4);
    wrapTextInColumn('.country', 3);
    wrapTextInColumn('.name', 2);
});

$(function () {
    $('#active-user').on('click', function () {
        $('#customSearchBox').val('');
        $('#active-user-table').DataTable().search('').draw();
        $('#active-user-table').DataTable().ajax.reload();

    });

    $('#block-user').on('click', function () {
        $('#customSearchBox').val('');
        $('#block-user-table').DataTable().search('').draw();
        $('#block-user-table').DataTable().ajax.reload();
    });
    // Initialize peer table
    var pendingAapproval = $('#block-user-table').DataTable({
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
        ajax: fetchBlockUsersData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#block-user-table').DataTable().page.info();
                return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
            },
            className: 'fontManage'
        },
        {
            data: 'name',
            name: 'name',
            className: 'fontManage'
        },
        {
            data: 'email',
            name: 'email',
            className: 'fontManage'
        },
        {
            data: 'organization',
            name: 'organization',
            className: 'fontManage'
        },
        {
            data: 'department',
            name: 'department',
            className: 'fontManage'
        },
        {
            data: 'jobTitle',
            name: 'jobTitle',
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

    // Initialize organization table
    var activeOrganizations = $('#active-user-table').DataTable({
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
        ajax: fetchUsersData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#active-user-table').DataTable().page.info();
                return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
            },
            className: 'fontManage'
        },
        {
            data: 'name',
            name: 'name',
            className: 'fontManage'
        },
        {
            data: 'email',
            name: 'email',
            className: 'fontManage'
        },
        {
            data: 'organization',
            name: 'organization',
            className: 'fontManage'
        },
        {
            data: 'department',
            name: 'department',
            className: 'fontManage'
        },
        {
            data: 'jobTitle',
            name: 'jobTitle',
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


    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        $('#deleteId').val(id);
        $('#delete').modal('show');

        // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
        $('#confirmDelete').off('click').on('click', function () {
            var id = $('#deleteId').val();
            $.LoadingOverlay("show");
            $.ajax({
                url: 'users/delete/' + id,
                type: 'DELETE',
                data: {
                    _method: 'DELETE',
                    _token: $('input[name=_token]').val(),
                },
                success: function (response) {
                    $('#delete').modal('hide');
                    $('#active-user-table').DataTable().ajax.reload();
                    $('#block-user-table').DataTable().ajax.reload();
                    $.LoadingOverlay("hide");
                    toastr.success('User has been deleted successfully');
                },
                error: function (xhr) {
                    $('#delete').modal('hide');
                    $.LoadingOverlay("hide");
                    let errorMessage = xhr.responseJSON?.error || 'Failed to delete the User. Please try again.';
                    toastr.error(errorMessage);
                }
            });
        });

        $('#cancelDelete').click(function () {
            $('#delete').modal('hide');
        });
    });
    $(document).on('click', '.block', function () {
        var id = $(this).data('id');
        $('#blockId').val(id);
        $('#block').modal('show');
        // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
        $('#confirmBlock').off('click').on('click', function () {
            var id = $('#blockId').val();
            $.LoadingOverlay("show");
            $.ajax({
                url: 'users/block/' + id,
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: $('input[name=_token]').val(),
                },
                success: function (response) {
                    $('#block').modal('hide');
                    $('#active-user-table').DataTable().ajax.reload();
                    $.LoadingOverlay("hide");
                    toastr.success('User has been blocked successfully');
                },
                error: function (xhr) {
                    $('#block').modal('hide');
                    $.LoadingOverlay("hide");
                    let errorMessage = xhr.responseJSON?.error || 'Failed to block this User. Please try again.';
                    toastr.error(errorMessage);
                }
            });
        });

        $('#cancelDelete').click(function () {
            $('#delete').modal('hide');
        });
    });
    $(document).on('click', '.unblock', function () {
        var id = $(this).data('id');
        console.log(id);
        $('#unblockId').val(id);
        $('#unblock').modal('show');
        // Unbind any previous click event on #confirmDelete to prevent duplicate triggers
        $('#confirmunBlock').off('click').on('click', function () {
            var id = $('#unblockId').val();
            $.LoadingOverlay("show");
            $.ajax({
                url: 'users/unblock/' + id,
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: $('input[name=_token]').val(),
                },
                success: function (response) {
                    $('#unblock').modal('hide');
                    $('#block-user-table').DataTable().ajax.reload();
                    $.LoadingOverlay("hide");
                    toastr.success('User has been un-blocked successfully');
                },
                error: function (xhr) {
                    $('#unblock').modal('hide');
                    $.LoadingOverlay("hide");
                    let errorMessage = xhr.responseJSON?.error || 'Failed to un-block this User. Please try again.';
                    toastr.error(errorMessage);
                }
            });
        });

        $('#cancelDelete').click(function () {
            $('#delete').modal('hide');
        });
    });
});
