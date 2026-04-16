
$(document).ready(function () {


    var selectedYear = new Date().getFullYear();
    $('#yearlyDropDown option').removeAttr('selected');

    if ($('#yearlyDropDown option[value="' + selectedYear + '"]').length === 0) {
        $('#yearlyDropDown').append(
            $("<option>", {
                value: selectedYear,
                text: selectedYear,
                selected: true
            })
        );
    } else {
        $('#yearlyDropDown').val(selectedYear);
    }
    // Call the feedbackReport function with the selected year
    feedbackReport(selectedYear);

$(document).on('change', '#yearlyDropDown', function () {
    var selectedYear = $(this).val();
    feedbackReport(selectedYear);
});

var myChart = null;

function feedbackReport(selectedYear) {


    var dashboardRoute = "/admin/chart/" + selectedYear;
    $.ajax({
         url: dashboardRoute,
            type: "GET",
            data: { year: selectedYear },
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
        success: function (response) {

                if (myChart) {
                    myChart.destroy();
                }
                $.LoadingOverlay("hide");
                var updatedData = response;
                    var labels =  updatedData.labels;
                    var meetingData = updatedData.data;
                $('#firstSpan').text(numberWithCommas(updatedData.total));
                const ctx = document.getElementById('barChart');

                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Reviews',
                            data: meetingData,
                            borderWidth: 0,
                            backgroundColor: '#2383E2',
                            borderRadius: 4,

                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    display: false,
                                    stepSize: 0,
                                    suggestedMin: 0,
                                    precision: 0
                                },
                                grid: {
                                    display: false,
                                },
                                display:false
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    display: true,
                                },
                            }

                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });

        },

            error: function (error) {
                $.LoadingOverlay("hide");
            }
    });
};

function numberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


    });

