document.addEventListener('DOMContentLoaded', function () {
    displayAlert();
});

function displayAlert() {
    const alertContainer = $('#alertContainer');
    const alertMessage = localStorage.getItem('alertMessage');
    const alertType = localStorage.getItem('alertType');
    if (alertMessage) {
        alertContainer.empty();
        const alertDiv = $('<div class="alert" role="alert"></div>');
        alertDiv.addClass(alertType === 'success' ? 'alert-success' : 'alert-danger');
        alertDiv.text(alertMessage);
        alertContainer.append(alertDiv);
        localStorage.removeItem('alertMessage');
        localStorage.removeItem('alertType');
    }
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
        submitForm();
    }
}

function showPosition(position) {
    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);
    submitForm();
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
    submitForm();
}

function submitForm() {
    var pcd_name = $('#pcd_name').val();
    var pcd_contact = $('#pcd_contact').val();
    var pcd_email = $('#pcd_email').val();
    var address = $('#address').val();
    var latitude = $('#latitude').val();
    var longitude = $('#longitude').val();
    var pt_id = $('#pt_id').val();
    var pcd_id = $('#pcd_id').val();

    // Log each variable to the console
    console.log("Name: " + pcd_name);
    console.log("Contact Number: " + pcd_contact);
    console.log("Email Address: " + pcd_email);
    console.log("Address Remark: " + address);
    console.log("Latitude: " + latitude);
    console.log("Longitude: " + longitude);
    console.log("Patient ID: " + pt_id);
    console.log("Caregiver ID: " + pcd_id);

    // Validate input values
    if (pcd_name && pcd_contact && pcd_email) {
        $.ajax({
            url: 'register_guest_add.php',
            method: 'POST',
            dataType: 'json',
            data: {
                register_btn: 1,
                mp_reporter_name: pcd_name,
                mp_reporter_contact_no: pcd_contact,
                mp_reporter_email: pcd_email,
                mp_remark: address,
                mp_latitude: latitude,
                mp_longitude: longitude,
                pt_id: pt_id,
                pcd_id: pcd_id
            },
            success: function (response) {
                localStorage.setItem('alertMessage', response.message);
                localStorage.setItem('alertType', response.status);
                window.location.replace('register_guest.php');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while submitting the form.');
            }
        });
    } else {
        alert('Please fill all the fields.');
    }
}