<?php
session_start();
$ipage = true;
$title = "Add QR CODE for REGISTERED USER";

//process
require_once("function/function.php");
if (isset($_GET['pt_id'])) {
    $patObj = new patient($_GET['pt_id']);
    $careObj = new caregiver($patObj->data['pcd_id']);
    $dtObj = new dementia($patObj->data['dt_id']);
}
//header
require_once("sub/header.php");

//content
?>

<div class="container">

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Report this Person of Dementia as missing</h3>
            </div>
            <div id="alertContainer"></div>
            <div class="card-body">

                <div class="container py-4">
                    <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3">
                        <div class="col">
                            <div class="card">
                                <div class="text-center">
                                    <img src="<?php echo $patObj->data['pt_photo_path']; ?>" class="rounded img-fluid" height=400 width=400>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Personal Info</h5>
                                    <table class="table">
                                        <tr>
                                            <td>IC:</td>
                                            <td><?php echo $patObj->data['pt_ic']; ?></td>
                                            <input type="hidden" id="pt_ic" value="<?php echo $patObj->data['pt_ic']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td><?php echo $patObj->data['pt_name']; ?></td>
                                            <input type="hidden" id="pt_name" value="<?php echo $patObj->data['pt_name']; ?>">
                                        </tr>
                                        <tr>
                                            <td>DOB:</td>
                                            <td><?php echo age_converter($patObj->data['pcd_dob']); ?> Years Old</td>
                                            <input type="hidden" id="pt_dob" value="<?php echo age_converter($patObj->data['pcd_dob']); ?>">
                                        </tr>
                                        <tr>
                                            <td>Dementia Type:</td>
                                            <td><?php echo $dtObj->data['dt_name']; ?></td>
                                            <input type="hidden" id="pt_dementia_type" value="<?php echo $dtObj->data['dt_name']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Dementia Stage:</td>
                                            <td><?php echo $patObj->data['pt_stage']; ?></td>
                                            <input type="hidden" id="pt_stage" value="<?php echo $patObj->data['pt_stage']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Caregiver Name:</td>
                                            <td><?php echo $careObj->data['pcd_name']; ?></td>
                                            <input type="hidden" id="caregiver_name" value="<?php echo $careObj->data['pcd_name']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Caregiver Contact Number:</td>
                                            <td><?php echo $careObj->data['pcd_contact']; ?></td>
                                            <input type="hidden" id="caregiver_contact" value="<?php echo $careObj->data['pcd_contact']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td><?php echo $careObj->data['pcd_email']; ?></td>
                                            <input type="hidden" id="caregiver_email" value="<?php echo $careObj->data['pcd_email']; ?>">
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td><?php echo $careObj->data['pcd_addr']; ?></td>
                                            <input type="hidden" id="caregiver_address" value="<?php echo $careObj->data['pcd_addr']; ?>">
                                        </tr>
                                    </table>

                                    <input type="hidden" id="latitude2" name="latitude">
                                    <input type="hidden" id="longitude2" name="longitude">
                                    <input type="hidden" id="pt_id" name="pt_id" value="<?php echo @$_GET['pt_id']; ?>">
                                    <input type="hidden" id="pcd_id" name="pcd_id" value="<?php echo @$patObj->data['pcd_id']; ?>">
                                </div>

                                <div class="card-footer">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" id="updateButton">Update Personal Info</button>
                                        <a href="nav_page.php" class="btn btn-secondary">
                                            < HomePage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    (function() {
        document.getElementById('updateButton').addEventListener('click', function(event) {
            // Prevent the default action if necessary
            event.preventDefault();

            // Retrieve the data from the hidden input fields
            var ic = document.getElementById('pt_ic').value;
            var name = document.getElementById('pt_name').value;
            var dob = document.getElementById('pt_dob').value;
            var dementiaType = document.getElementById('pt_dementia_type').value;
            var stage = document.getElementById('pt_stage').value;
            var caregiverName = document.getElementById('caregiver_name').value;
            var contactNumber = document.getElementById('caregiver_contact').value;
            var email = document.getElementById('caregiver_email').value;
            var address = document.getElementById('caregiver_address').value;
            var ptId = document.getElementById('pt_id').value;
            var pcdId = document.getElementById('pcd_id').value;

            // Continue with the geolocation logic
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude2 = position.coords.latitude;
                    var longitude2 = position.coords.longitude;

                    // Set the hidden input values
                    document.getElementById('latitude2').value = latitude2;
                    document.getElementById('longitude2').value = longitude2;

                    // Log the latitude and longitude to the console
                    console.log('Latitude:', latitude2);
                    console.log('Longitude:', longitude2);

                    // Send data using AJAX
                    $.ajax({
                        url: 'add_missing_pwd_for_pcd_add.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            pt_ic: ic,
                            pt_name: name,
                            pt_dob: dob,
                            pt_dementia_type: dementiaType,
                            pt_stage: stage,
                            mp_reporter_name: caregiverName,
                            mp_reporter_contact_no: contactNumber,
                            mp_reporter_email: email,
                            pt_id: ptId,
                            pcd_id: pcdId,
                            mp_latitude: latitude2,
                            mp_longitude: longitude2
                        },
                        success: function(response) {
                            console.log(response.data);
                            localStorage.setItem('alertMessage', response.message);
                            localStorage.setItem('alertType', response.status);
                            displayAlert();

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('An error occurred while submitting the form.');
                        }
                    });
                }, showError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        });

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }

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

        $(document).ready(function() {
            displayAlert();
        });
    })();
</script>

<?php

require_once("sub/footer.php");
?>