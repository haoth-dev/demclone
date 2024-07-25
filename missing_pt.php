<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");
if (isset($_GET['pt_id'])) {
    $ptObj = new patient($_GET['pt_id']);
}

//header
require_once("sub/header.php");

//content
?>

<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            Enter your info
        </div>
        <div class="card-body">
            <form id="contactForm" method="post" action="missing_pt_process.php" onsubmit="getLocation(event);">
                <div class="form-floating mb-3">
                    <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="mp_reporter" />
                    <label for="icNumber">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="mp_contact" />
                    <label for="icNumber">Contact Number</label>
                </div>

                <div class="form-floating row mb-3">
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="register">Report Found this person</button>
                    </div>
                </div>

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">

                <input type="hidden" name="pcd_id" value="<?php echo $ptObj->data['pcd_id'] ?>">
                <input type="hidden" name="pt_id" value="<?php echo $ptObj->data['pt_id'] ?>">

                <div class="form-floating row">
                    <div class="col-12">
                        <a href="medication.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Meds Page</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function getLocation(event) {
        event.preventDefault(); // Prevent form submission

        if (navigator.permissions) {
            navigator.permissions.query({
                name: 'geolocation'
            }).then(function(result) {
                if (result.state === 'granted' || result.state === 'prompt') {
                    getCurrentLocation();
                } else if (result.state === 'denied') {
                    handleGeolocationError('Permission denied. Please allow location access in your browser settings.');
                }
            }).catch(function(error) {
                console.error('Error querying geolocation permissions:', error);
                handleGeolocationError('Error querying geolocation permissions.');
            });
        } else {
            getCurrentLocation();
        }
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                console.log('Latitude:', latitude); // Debug log
                console.log('Longitude:', longitude); // Debug log

                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;

                console.log('Form data ready, submitting form.'); // Debug log

                document.getElementById('contactForm').submit();
            }, function(error) {
                console.error('Error getting geolocation:', error);
                var errorMessage = 'Error getting your location. Please try again or enter manually.';
                if (error.code === 1) {
                    errorMessage = 'Permission denied. Please allow location access in your browser settings.';
                } else if (error.code === 2) {
                    errorMessage = 'Location information is unavailable. Please try again later or enter manually.';
                }
                handleGeolocationError(errorMessage);
            });
        } else {
            handleGeolocationError('Geolocation is not supported by this browser.');
        }
    }

    function handleGeolocationError(message) {
        alert(message);
    }
</script>

<?php
require_once("sub/footer.php");
?>