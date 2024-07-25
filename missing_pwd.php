<?php
session_start();
$ipage = true;
$title = "Missing PWD";

//process
require_once("function/function.php");

$missObj = new missing();
$missList = $missObj->list_all_missing_pt();

//header
require_once("sub/header.php");

//content
?>

<div class="container">
    <br>
    <div class="row">
        <div class="col-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    List of Missing PWD
                </div>
                <div class="card-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>No</th>
                            <th>Missing PWD</th>
                            <th>PWD Caregiver</th>
                            <th>Reporter Name</th>
                            <th>Reporter Number</th>
                            <th>Added</th>

                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            if (!empty($missList)) {
                                foreach ($missList as $value) {
                                    $patObj = new patient($value['pt_id']);
                                    $careObj = new caregiver($value['pcd_id']);
                            ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $patObj->data['pt_name']; ?></td>
                                        <td><?php echo $careObj->data['pcd_name']; ?></td>
                                        <td><?php echo $value['mp_reporter_name']; ?></td>
                                        <td><?php echo  $value['mp_reporter_contact_no']; ?></td>
                                        <td><?php echo  recent($value['mp_date']); ?></td>



                                        <input type="hidden" class="mp_latitude" value="<?php echo $value['mp_latitude']; ?>">
                                        <input type="hidden" class="mp_longitude" value="<?php echo $value['mp_longitude']; ?>">
                                        <td>
                                            <button class="btn btn-outline-primary view-map" data-bs-toggle="modal" data-bs-target="#mapModal"><i class="fas fa-map-marker-alt"></i></button>
                                            <a href="missing_pwd_edit.php?mp_id=<?php echo $value['mp_id']; ?>" class="btn btn-outline-primary"><i class="far fa-newspaper"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-warning" role="alert">
                                            No user added yet
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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
                        <div id="map" style="height: 400px;"></div>
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
        marker = new google.maps.marker.AdvancedMarkerElement({
            position: new google.maps.LatLng(lat, lng),
            map: map,
        });
    }

    $(document).ready(function() {
        $('.view-map').on('click', function() {
            var row = $(this).closest('tr');
            var lat = row.find('.mp_latitude').val();
            var lng = row.find('.mp_longitude').val();
            initMap(lat, lng);
        });
    });
</script>