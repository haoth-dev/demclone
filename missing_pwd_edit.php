<?php
session_start();
$ipage = true;
$title = "Missing PWD details";

//process
require_once("function/function.php");
if (isset($_GET['mp_id'])) {
    $mpObj = new missing($_GET['mp_id']);
    $ptObj = new patient($mpObj->data['pt_id']);
    $pcObj = new caregiver($mpObj->data['pcd_id']);
    $demObj = new dementia($ptObj->data['dt_id']);
}

if (isset($_POST['edit'])) {
    $missObj = new missing($_POST['mp_id']);
    $update = $missObj->update_inc_status($_POST);
    if ($result) {
        $alert = "<div class='alert alert-success' role='alert'>Update sucess</div>";
    } else {
        $alert = "<div class='alert alert-danger' role='alert'>Update failed</div>";
    }
    $mpObj = new missing($_POST['mp_id']);
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Missing PWD Detail</h4>
    <form id="contactForm" method='post'>
        <input type="hidden" name=mp_id value="<?php echo $_GET['mp_id'] ?>">
        <input type="hidden" name=pcd_id value="<?php echo $pcObj->data['pcd_id'] ?>">
        <input type="hidden" name=pt_id value="<?php echo $ptObj->data['pt_id'] ?>">

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Missing Case ID</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_id'] ?>" readonly>

        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">PWD Name</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $ptObj->data['pt_name'] ?>" readonly>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ptModal" type="button" id="button-addon2"><i class="fas fa-info-circle"></i> Info</button>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Caregiver Name</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $pcObj->data['pcd_name'] ?>" readonly>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#pcdModal" type="button" id="button-addon2"><i class="fas fa-info-circle"></i> Info</button>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Latitude | Longitude</span>
            <input type="text" aria-label="mp_latitude" class="form-control mp_latitude" value="<?php echo $mpObj->data['mp_latitude'] ?>" readonly>
            <input type="text" aria-label="mp_longitude" class="form-control mp_longitude" value="<?php echo $mpObj->data['mp_longitude'] ?>" readonly>
            <button class="btn btn-outline-secondary view-map" data-bs-toggle="modal" data-bs-target="#mapModal" type="button" id="button-addon2"><i class="fas fa-info-circle"></i> Info</button>
        </div>




        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Date</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_date'] ?>" readonly>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Reported Name</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_reporter_name'] ?>" readonly>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Reporter Contact number</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_reporter_contact'] ?>" readonly>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Reporter Email</span>
            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_reporter_email'] ?>" readonly>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="meds_desc" readonly><?php echo $mpObj->data['mp_remark'] ?></textarea>
            <label for="address"> Remark</label>

        </div>


    </form>

    <!-- Patient Modal -->
    <div class="modal fade" id="ptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Patient Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Front Side Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-card">
                                <div class="photo-column">
                                    <img id="modal-profile-photo" src="<?php echo htmlspecialchars($ptObj->data['pt_photo_path']); ?>" alt="Profile Photo" class="profile-photo">
                                </div>
                                <div class="details-column">
                                    <div class="details-item">
                                        <h3>Name</h3>
                                        <p><span id="modal-pt-name"><?php echo htmlspecialchars($ptObj->data['pt_name']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Primary Caregiver Name</h3>
                                        <p><span id="modal-pt-name"><?php echo htmlspecialchars($pcObj->data['pcd_name']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Contact Number</h3>
                                        <p><span id="modal-pt-contact"><?php echo htmlspecialchars($pcObj->data['pcd_contact']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Dementia Type</h3>
                                        <p><span id="modal-dementia-type"><?php echo htmlspecialchars($demObj->data['dt_name']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Stage</h3>
                                        <p><span id="modal-stage"><?php echo htmlspecialchars($ptObj->data['pt_stage']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Location</h3>
                                        <p><span id="modal-location"><?php echo htmlspecialchars($ptObj->data['pt_location']); ?></span></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Caregiver Modal -->
    <div class="modal fade" id="pcdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Caregiver Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Front Side Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-card">
                                <div class="photo-column">
                                    <img id="modal-profile-photo" src="<?php echo htmlspecialchars($pcObj->data['pcd_photo_path']); ?>" alt="Profile Photo" class="profile-photo">
                                </div>
                                <div class="details-column">
                                    <div class="details-item">
                                        <h3>Name</h3>
                                        <p><span id="modal-pt-name"><?php echo htmlspecialchars($pcObj->data['pcd_name']); ?></span></p>
                                    </div>

                                    <div class="details-item">
                                        <h3>DOB</h3>
                                        <p><span id="modal-pt-name"><?php echo htmlspecialchars(age_converter($pcObj->data['pcd_date'])); ?> Years Old</span></p>
                                    </div>

                                    <div class="details-item">
                                        <h3>Contact Number</h3>
                                        <p><span id="modal-pt-contact"><?php echo htmlspecialchars($pcObj->data['pcd_contact']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Email</h3>
                                        <p><span id="modal-dementia-type"><?php echo htmlspecialchars($pcObj->data['pcd_email']); ?></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Address</h3>
                                        <p><span id="modal-stage"><?php echo htmlspecialchars($pcObj->data['pcd_addr']); ?></span></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</div>

<!--MAP Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Location of Missing PWD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        Map Location
                    </div>
                    <div class="card-body">
                        <div id="map" style="width:400px;height: 400px;"></div>
                    </div>
                    <div class="card-footer text-muted">
                        Provided by Google Maps
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

require_once("sub/footer.php");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXQRTPyp4IpEJ_fi_I2SlJfwKCizPWWC8&libraries=marker&map_ids=a3c3e35b81b54559" async defer></script>
<script>
    var map;
    var marker;

    function initMap(lat, lng) {
        var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: 15,
            mapId: 'a3c3e35b81b54559' // Use your valid Map ID
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
        });
    }

    $(document).ready(function() {
        $('.view-map').on('click', function() {
            var lat = $(this).closest('.input-group').find('.mp_latitude').val();
            var lng = $(this).closest('.input-group').find('.mp_longitude').val();
            initMap(parseFloat(lat), parseFloat(lng));
        });
    });
</script>