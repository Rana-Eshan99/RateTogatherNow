document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName("btnStyle");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function(button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function() {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function(button) {
                button.style.background = "transparent"; // Change color to transparent
                button.style.color = "#007bff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function() {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function() {
                    // Revert to original transparent style when hover ends
                    button.style.color = "#007bff";
                    button.style.backgroundColor = "transparent";
                    button.style.borderColor = "#007bff";
                });
            });
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName("btnStyles");

    // Loop through all elements with the "btnStyle" class
    Array.prototype.forEach.call(buttons, function(button) {
        // On click or touch event, change the button color for mobile screens
        button.addEventListener("click", function() {
            this.style.background = "#6941C6"; // Change color on click/tap
        });
    });

    // When the user comes back to the page (without reload), make the button background transparent
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) { // Check if the page is loaded from cache (e.g., when using the back button)
            Array.prototype.forEach.call(buttons, function(button) {
                button.style.background = "#007bff"; // Change color to transparent
                button.style.color = "#fff"; // Change text color
                button.style.borderColor = "#007bff"; // Change border color

                // Apply hover effect-like styles
                button.addEventListener("mouseover", function() {
                    button.style.color = "#fff"; // Change text color on hover
                    button.style.backgroundColor = "#007bff"; // Change background color on hover
                    button.style.borderColor = "#007bff"; // Change border color on hover
                });

                button.addEventListener("mouseout", function() {
                    // Revert to original transparent style when hover ends
                    button.style.color = "#fff";
                    button.style.backgroundColor = "#007bff";
                    button.style.borderColor = "#007bff";
                });
            });
        }
    });
});


$(document).ready(function() {
    // On Click of feedback button check that user is authenticated or not.

    // On Click of pagination links send the ajax request and load the desired the list

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        // Start the loader
        $.LoadingOverlay("show");
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                // Stop the loader
                $.LoadingOverlay("hide");
                $("#data-wrapper-final").html('');
                $("#data-wrapper-final").html(data.html);
            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");
                console.log(error);
                // Handle error
                if (xhr.state.status == 400 || xhr.state.status == 500) {
                    toastr.error(xhr.responseJSON.message);
                }
                else {
                    toastr.error(xhr.responseJSON.response.message);
                }
                return false;
            }
        });
    });
});

$(document).ready(function() {
    // Gender Chart
    var dataValues = window.Laravel.dataValues;
    var total = dataValues.reduce((acc, val) => acc + val, 0);

    const doughnutlabel = {
        beforeDraw: function(chart) {
            var width = chart.width,
                height = chart.height,
                ctx = chart.ctx;

            ctx.restore();

            // Text to be drawn
            var text = '100%',
                subText = 'GENDER GRAPH';

            // Set font style for the percentage text (first line)
            ctx.font = '700 ' + (height / 8).toFixed(0) + "px Poppins"; // Apply Poppins font with font-weight 700
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#414D55'; // Apply the color #414D55

            // Calculate the center of the doughnut's cutout area
            var textX = (chart.chartArea.left + chart.chartArea.right) / 2;
            var textY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

            // Draw the percentage text in the center
            ctx.fillText(text, textX, textY);

            // Set font style for the GENDER GRAPH text (second line)
            ctx.font = 'normal ' + (height / 24).toFixed(0) + "px Poppins"; // Smaller font for the label, still using Poppins
            ctx.fillStyle = '#414D55'; // Ensure the same color is applied

            // Draw the label text slightly below the percentage
            ctx.fillText(subText, textX, textY + (height / 12));

            ctx.save();
        }
    };


    var genderCtx = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: dataValues.map((value, index) => {
                var percentage = ((value / total) * 100).toFixed(0);
                percentage = isNaN(percentage) ? 0 : percentage;
                var labelNames = ['Males', 'Females', 'Others'];
                return percentage + '% ' + labelNames[index];
            }),
            datasets: [{
                data: dataValues,
                backgroundColor: ['#b0b698', '#ba4b5b',
                    '#f8b268'
                ], // Colors matching the desired design
                hoverBackgroundColor: ['#8C9E5E', '#904347', '#D4B574'],
                borderWidth: 3 // Completely remove the border to eliminate the outer layer
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1.5,
            cutout: '75%', // Thin doughnut appearance
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom', // Legend at the bottom
                    labels: {
                        boxWidth: 16,
                        padding: 10,
                        font: {
                            size: 14,
                        },
                        color: '#6B7280',
                        generateLabels: function(chart) {
                            return chart.data.labels.map(function(label, index) {
                                return {
                                    text: label,
                                    fillStyle: chart.data.datasets[0].backgroundColor[
                                        index],
                                    strokeStyle: chart.data.datasets[0].backgroundColor[
                                        index],
                                    lineWidth: 2,
                                    hidden: false,
                                    index: index,
                                    borderRadius: 2 // Add this to round corners
                                };
                            });
                        }
                    },
                    onClick: null // Disable hiding the chart on label click
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#fff', // White background for tooltip
                    titleColor: '#000', // Black title color
                    bodyColor: '#000', // Black text color
                    borderColor: '#fff', // Light border color for tooltip
                    borderWidth: 1,
                    displayColors: false, // Remove color box from tooltip
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            var percentage = ((value / total) * 100).toFixed(0);
                            return percentage + '% '; // Show category, value, and percentage
                        },
                        title: function() {
                            return ''; // No title in the tooltip
                        }
                    }
                },
            }
        },
        plugins : [doughnutlabel]
    });


    var totalwhite = window.Laravel.totalwhite;
    var totalblack = window.Laravel.totalblack;
    var totalhispanic = window.Laravel.totalhispanic;
    var totalmiddleEastern = window.Laravel.totalmiddleEastern;
    var totalamericanIndian = window.Laravel.totalamericanIndian;
    var totalasian = window.Laravel.totalasian;
    var totalhawaiian = window.Laravel.totalhawaiian;
    var totalothers = window.Laravel.totalothers;

    // Ethnicity Chart
    var ethnicityCtx = document.getElementById('ethnicityChart').getContext('2d');
    var ethnicityChart = new Chart(ethnicityCtx, {
        type: 'bar',
        data: {
            labels: [''],
            datasets: [{
                label: 'White',
                data: [totalwhite],
                backgroundColor: '#b4bd9b',
                hoverBackgroundColor: '#8C9E5E',
                borderSkipped: false,
                borderRadius: {
                    topLeft: 30,
                    bottomLeft: 30
                },
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',
            }, {
                label: 'Black',
                data: [totalblack],
                backgroundColor: '#81bdc3',
                hoverBackgroundColor: '#2E6C6A',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',

            }, {
                label: 'Hispanic or Latino',
                data: [totalhispanic],
                backgroundColor: '#f6cf98',
                hoverBackgroundColor: '#D8A762',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',
            }, {
                label: 'Middle Eastern',
                data: [totalmiddleEastern],
                backgroundColor: '#fdf8ec',
                hoverBackgroundColor: '#E2D4B7',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',

            }, {
                label: 'American Indian or Alaska Native',
                data: [totalamericanIndian],
                backgroundColor: '#fdba77',
                hoverBackgroundColor: '#E5B3A1',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',

            }, {
                label: 'Asian',
                data: [totalasian],
                backgroundColor: '#f9d6d3',
                hoverBackgroundColor: '#D8A5A5',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',

            }, {
                label: 'Native Hawaiian or Pacific Islander',
                data: [totalhawaiian],
                backgroundColor: '#1098f7',
                hoverBackgroundColor: '#3A637F',
                borderSkipped: false,
                borderRadius: 0,
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',

            }, {
                label: 'Others',
                data: [totalothers],
                backgroundColor: '#ccd5c3',
                hoverBackgroundColor: '#A5AD96',
                borderSkipped: false,
                borderRadius: {
                    topRight: 30,
                    bottomRight: 30
                },
                barThickness: 30,
                borderWidth: 1,
                borderColor: '#fff',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {}
                    },
                    grid: {
                        display: false // Disable grid lines
                    },
                    border: {
                        display: false // Remove the axis line
                    }
                },
                y: {
                    stacked: true,
                    display: true,
                    grid: {
                        display: false // Disable grid lines
                    },
                    border: {
                        display: false // Remove the axis line
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    });

    function getVisitorId() {
        let storedVisitorId = localStorage.getItem('visitorId');

        if (storedVisitorId) {
            document.getElementById('visitorId').value = storedVisitorId;
            return Promise.resolve(storedVisitorId);
        } else {
            return FingerprintJS.load()
                .then(fp => fp.get())
                .then(result => {
                    const visitorId = result.visitorId;
                    localStorage.setItem('visitorId', visitorId);

                    const visitorIdElement = document.getElementById('visitorId');
                    if (visitorIdElement) {
                        visitorIdElement.value = visitorId;
                    }

                    return visitorId;
                });
        }
    }

    getVisitorId().then(visitorId => {
    });

    getVisitorId().then(function(visitorId) {
        // Prepare the form data for AJAX submission
        var formData = {
            visitorId: visitorId,  // Include visitor ID here
        };

        $.ajax({
            url: ENDPOINT,
            type: 'GET',

            data: formData,
            success: function (response) {

            },
            error: function (xhr) {

            }
        });
    });

});
