function scd_account_update() {
    var l_username = $('#l_username').val();
    var current_pass = $('#current_pass').val();
    var new_pass = $('#new_pass').val();
    var c_new_pass = $('#c_new_pass').val();

    // Check if new_pass matches c_new_pass
    if (new_pass !== c_new_pass) {
        console.log('New passwords do not match.');
        var errorAlert = '<div class="alert alert-danger" role="alert">New passwords do not match.</div>';
        $('#alert-container').html(errorAlert);
        return; // Exit the function to prevent the AJAX request
    }

    var data = {
        "update_account": 1,
        "l_username": l_username,
        "current_pass": current_pass,
        "new_pass": new_pass,
        "c_new_pass": c_new_pass
    };

    // Show loading spinner
    $('#comment-loading-spinner').removeClass('d-none');

    $.ajax({
        url: 'scaregiver_edit_acc.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
            // Parse the response if it is not already a JSON object
            var array = (typeof response === 'string') ? JSON.parse(response) : response;

            if (array.success) {
                console.log(array.data);
                // Create and insert success alert
                var successAlert = '<div class="alert alert-success" role="alert">Password updated successfully!</div>';
                $('#alert-container').html(successAlert);
            } else {
                var errorAlert = '<div class="alert alert-danger" role="alert">' + array.data + '</div>';
                $('#alert-container').html(errorAlert);
            }
        },
        error: function (error) {
            console.log('AJAX request failed:', error);
            alert('AJAX request failed. Please try again.');
        },
        complete: function () {
            // Hide loading spinner
            $('#loading-spinner').addClass('d-none');
        }
    });
}
