$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    // Initialize organization table
    var activeOrganizations = $('#peers-review-table').DataTable({
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
        ajax: fetchPeerData,
        columns: [{
            data: 'id',
            name: 'id',
            render: function (data, type, row, meta) {
                // Calculate the continuous row number by adding the page offset
                var pageInfo = $('#peers-review-table').DataTable().page.info();
                return pageInfo.start + meta.row + 1; // `pageInfo.start` gives the starting index of the current page
            },
            className: 'fontManage'
        },
        {
            data: 'givenBy',
            name: 'givenBy',
            className: 'fontManage'
        },
        {
            data: 'peerName',
            name: 'peerName',
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
                return words.length > 11 ? words.slice(0, 11).join(" ") + '...' : data;
            },
            className: 'fontManage experience'
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
        url: '/admin/peers/reviews/' + id,
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

            $('#expericeFeedback').text(response.peer[0].experience);
            $('input[name="assistOther"]').val(response.peer[0].assistOther);
            $('input[name="collaborateTeam"]').val(response.peer[0].collaborateTeam);
            $('input[name="communicateUnderPressure"]').val(response.peer[0].communicateUnderPressure);
            $('input[name="dependableWork"]').val(response.peer[0].dependableWork);
            $('input[name="easyWork"]').val(response.peer[0].easyWork);
            $('input[name="meetDeadline"]').val(response.peer[0].meetDeadline);
            $('input[name="receivingFeedback"]').val(response.peer[0].receivingFeedback);
            $('input[name="respectfullOther"]').val(response.peer[0].respectfullOther);
            $('input[name="workAgain"]').val(response.peer[0].workAgain);
            $('input[name="deleteIdPeer"]').val(response.peer[0].id);



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
        //text size
        textSpan.style.fontSize = '16px';

        container.appendChild(starDiv);
        container.appendChild(textSpan);

        // now find % of all

        var total = assistOther + collaborateTeam + communicateUnderPressure + dependableWork + easyWork + meetDeadline + receivingFeedback + respectfullOther;
        var totalPercentage = (total / 8);
        document.getElementById('points').innerHTML = totalPercentage.toFixed(1);



    }
    // Trigger the update when the custom event is fired
    $(document).on('hiddenFieldsUpdated', function () {
        updateStarRatings();
    });
    updateStarRatings();
});
