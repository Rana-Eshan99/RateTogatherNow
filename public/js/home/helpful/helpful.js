$(document).ready(function () {
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

    // Event listener for thumbs up
    $(document).on('click', '.thumbs-up', function () {

        var id = $(this).data('id');  // Get the ID from the clicked thumbs up
        var form = $('#helpfulForm_' + id);  // Get the form related to this thumbs up/down

        let greenThumbsUp = false;
        if(($("#thumbsUp_" +id).attr("alt")) == "green-thumbs-up"){
            greenThumbsUp = true;
        }
        else{
            greenThumbsUp = false;
        }

        // Define the isFoundHelpful variable
        var isFoundHelpful = 1;



        // Send an AJAX POST request
        $.ajax({
            url: form.attr('action'),  // Get the form action URL
            method: form.attr('method'), // Get the form method (POST)
            data: form.serialize() + '&isFoundHelpful=' + isFoundHelpful + '&visitorId=' + visitorId,  // Append isFoundHelpful to form data
            success: function (response) {

                $("#thumbsUpCount_" + id).text(response.response.count);
                $("#thumbsDownCount_" + id).text(response.response.notHelpfulCount);
                if(greenThumbsUp == true){
                    // Set the thumbs Up to Un check state
                    $("#thumbsUp_" +id).attr('alt', 'thumbs-up');
                    $("#thumbsUp_" +id).attr('src', thumbsUpImageUrl);
                }
                else{
                    // Set the thumbs Up to check state i.e green
                    $("#thumbsUp_" +id).attr('alt', 'green-thumbs-up');
                    $("#thumbsUp_" +id).attr('src', greenThumbsUpImageUrl);
                }

                // Set the thumbs Down to Un check state
                $("#thumbsDown_" +id).attr('alt', 'thumbs-down');
                $("#thumbsDown_" +id).attr('src', thumbsDownImageUrl);
            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");
                console.log(error);

                // Handle error
                if (xhr.state.status == 400 || xhr.state.status == 500) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error(xhr.responseJSON.response.message);
                }
            }
        });
    });

    // Event listener for thumbs down
    $(document).on('click', '.thumbs-down', function () {
        var id = $(this).data('id');  // Get the ID from the clicked thumbs down
        var form = $('#helpfulForm_' + id);  // Get the form related to this thumbs up/down

        let redThumbsDown = false;
        if(($("#thumbsDown_" +id).attr("alt")) == "red-thumbs-down"){
            redThumbsDown = true;
        }
        else{
            redThumbsDown = false;
        }

        // Define the isFoundHelpful variable
        var isFoundHelpful = 0;


        // Send an AJAX POST request
        $.ajax({
            url: form.attr('action'),  // Get the form action URL
            method: form.attr('method'), // Get the form method (POST)
            data: form.serialize() + '&isFoundHelpful=' + isFoundHelpful + '&visitorId=' + visitorId,  // Append isFoundHelpful to form data
            success: function (response) {

                $("#thumbsDownCount_" + id).text(response.response.notHelpfulCount);
                $("#thumbsUpCount_" + id).text(response.response.count);
                if(redThumbsDown == true){
                    // Set the thumbs Down to Un check state
                    $("#thumbsDown_" +id).attr('alt', 'thumbs-down');
                    $("#thumbsDown_" +id).attr('src', thumbsDownImageUrl);
                }
                else{
                    // Set the thumbs Down to check state i.e red
                    $("#thumbsDown_" +id).attr('alt', 'red-thumbs-down');
                    $("#thumbsDown_" +id).attr('src', redThumbsDownImageUrl);

                }

                // Set the thumbs Up to Un check state
                $("#thumbsUp_" +id).attr('alt', 'thumbs-up');
                $("#thumbsUp_" +id).attr('src', thumbsUpImageUrl);
            },
            error: function (xhr, status, error) {
                // Stop the loader
                $.LoadingOverlay("hide");
                console.log(error);

                // Handle error
                if (xhr.state.status == 400 || xhr.state.status == 500) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error(xhr.responseJSON.response.message);
                }
            }
        });
    });

});
});
