<?php
session_start();
$ipage = true;
$title = "Admin Edit Incident";

//process
require_once("function/function.php");

$itObj = new inctype();
$itList = $itObj->list_all_inc_type();
$careObj = new caregiver();
$careList = $careObj->get_all_caregiver_data();

if (isset($_GET['inc_id'])) {
    $incGetObj = new incident($_GET['inc_id']);
    $mpObj = new missing(null, $_GET['inc_id']);
    $ptObj = new patient($mpObj->data['pt_id']);
    $pcObj = new caregiver($mpObj->data['pcd_id']);
    $demObj = new dementia($ptObj->data['dt_id']);
}

if (isset($_POST['edit'])) {
    $incObj = new incident();

    $clean_post = $incObj->sanitize_post_data($_POST);

    $result = $incObj->admin_update_incident($clean_post);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $incObj->e_log;
        $success = false;
    }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Edit Incident</h4>

    <nav>
        <div class="nav nav-tabs" id="edit-inc-tab" role="tablist">
            <button class="nav-link" id="nav-editform-tab" data-bs-toggle="tab" data-bs-target="#nav-editform" type="button" role="tab" aria-controls="nav-editform" aria-selected="false">Detail</button>
            <button class="nav-link" id="nav-missingDetail-tab" data-bs-toggle="tab" data-bs-target="#nav-missingDetail" type="button" role="tab" aria-controls="nav-missingDetail" aria-selected="false">Missing PWD</button>
            <button class="nav-link" id="nav-comment-tab" data-bs-toggle="tab" data-bs-target="#nav-comment" type="button" role="tab" aria-controls="nav-comment" aria-selected="false">Comment</button>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade" id="nav-editform" role="tabpanel" aria-labelledby="nav-editform-tab">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Note!</h4>
                <p>For Missing PWD type incident. Please add date and time last seen person with dementia at incident remark as this info is essential for filing police report. </p>
                <hr>

            </div>
            <?php
            if (!empty($_POST)) {
                success_alert(@$success, "Successfully Edit Incident", @$err);
                $incGetObj = new incident($_GET['inc_id']);
            }
            ?>


            <form id="contactForm" method='post'>

                <input type="hidden" name="inc_id" value="<?php echo $_GET['inc_id'] ?>">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" placeholder="Incident ID" data-sb-validations="required" name="inc_id" value="<?php echo $incGetObj->data['inc_id'] ?>" readonly />
                    <label for="icNumber">Incident ID</label>
                </div>
                <?php
                if (!empty($careList)) {
                ?>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">User</label>
                        <select class="form-select" id="inputGroupSelect01" name="inc_caller" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?>>
                            <?php
                            foreach ($careList as $value) {
                            ?>
                                <option <?php echo selection_equal($value['pcd_email'], $incGetObj->data['inc_caller']); ?> value="<?php echo $value['pcd_email'] ?>"><?php echo $value['pcd_name']; ?></option>
                            <?php

                            }
                            ?>
                        </select>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning" role="alert">
                        No inc type added yet, Please email your admin at dementiabn@dementiabn.xyz
                    </div>
                <?php
                }
                ?>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" placeholder="Incident Title" data-sb-validations="required" name="inc_title" value="<?php echo $incGetObj->data['inc_title'] ?>" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?> />
                    <label for="icNumber">Incident Title</label>

                </div>



                <div class="form-floating mb-3">
                    <input class="form-control" type="datetime-local" placeholder="Tiket Opened" data-sb-validations="required" name="inc_date_opened" value="<?php echo $incGetObj->data['inc_date_opened'] ?>" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?> readonly />
                    <label for="icNumber">Incident Opened</label>

                </div>

                <?php
                if (!empty($itList)) {
                ?>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Type</label>
                        <select class="form-select" id="inputGroupSelect01" name="it_id" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?>>
                            <?php
                            foreach ($itList as $value) {
                            ?>
                                <option <?php echo selection_equal($value['it_id'], $incGetObj->data['it_id']); ?> value="<?php echo $value['it_id'] ?>"><?php echo $value['it_name']; ?></option>
                            <?php

                            }
                            ?>
                        </select>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning" role="alert">
                        No inc type added yet, Please email your admin at dementiabn@dementiabn.xyz
                    </div>
                <?php
                }
                ?>

                <div class="form-floating mb-3">
                    <textarea <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?> class="form-control" id="address" type="text" placeholder="Incident Remark" style="height: 10rem;" data-sb-validations="required" name="inc_desc"><?php echo $incGetObj->data['inc_desc'] ?></textarea>
                    <label for="address">Incident Remark</label>

                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text">Inc Status</label>
                    <select class="form-select" name="inc_status" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?>>
                        <option <?php echo selection_equal('New', $incGetObj->data['inc_status']); ?> value="New">New</option>
                        <option <?php echo selection_equal('In-Progress', $incGetObj->data['inc_status']); ?> value="In-Progress">In-Progress</option>
                        <option <?php echo selection_equal('Resolved', $incGetObj->data['inc_status']); ?> value="Resolved">Resolved</option>
                        <option <?php echo selection_equal('Cancelled', $incGetObj->data['inc_status']); ?> value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <?Php
                if ($incGetObj->data['inc_status'] == 'Resolved') {
                ?>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="icNumber" type="text" placeholder="Tiket Opened" data-sb-validations="required" value="<?php echo $incGetObj->data['inc_date_closed'] ?>" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?> />
                        <label for="icNumber">Incident Resolved Time</label>

                    </div>
                <?php
                }
                ?>

                <div class="form-floating row mb-3">
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit" <?php echo  if_resolved_disabled_field($incGetObj->data['inc_status']); ?>>Edit Incident</button>
                    </div>
                </div>

                <div class="form-floating row">
                    <div class="col-12">
                        <a href="admin_incident.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Incident Page</a>
                    </div>
                </div>
            </form>
        </div>
        <!--missing pwd tab start -->
        <div class="tab-pane fade" id="nav-missingDetail" role="tabpanel" aria-labelledby="nav-missingDetail-tab">
            <h4>Missing PWD Detail</h4>
            <?php
            if (!empty($mpObj->data['mp_id'])) {
            ?>
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
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $mpObj->data['mp_reporter_contact_no'] ?>" readonly>
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
            <?php
            } else {
            ?>
                <div class="alert alert-warning" role="alert">
                    No Data
                </div>
            <?php
            }
            ?>


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

        <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
            <!-- Alert Container -->
            <div id="comment-alert-container"></div>
            <!-- Loading Spinner -->
            <div id="comment-loading-spinner" class="d-none">
                <div class="spinner-grow text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <br>
            <h4>Comment Section</h4>
            <input type="hidden" id="inc_id" value=<?php echo $_GET['inc_id']; ?>>
            <input type="hidden" id="pcd_id" value=<?php echo $_SESSION['pcd_id']; ?>>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="c_content" type="text" placeholder="Incident Remark" style="height: 10rem;" data-sb-validations="required"></textarea>
                <label for="comment">Incident Remark</label>
            </div>
            <div class="form-floating row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary btn-lg btn-block std-btn" id="post" name="post" onclick="addComment()">Post</button>
                </div>
            </div>
            <hr>
            <div id="comment-card-list"></div>
        </div>
    </div>
</div><!-- Container end -->

<script src="resource/js/incident.js"></script>
<script>
    $(document).ready(function() {
        fetchComments();

        function fetchComments() {
            var c_ref_id = $('#inc_id').val();

            $.ajax({
                url: 'admin_incident_get_comment.php',
                type: 'GET',
                data: {
                    c_ref_id: c_ref_id
                },
                success: function(response) {
                    var array = (typeof response === 'string') ? JSON.parse(response) : response;

                    if (array.success) {
                        console.log(array.data); // Debugging: Check the structure of the response
                        display_list_comment(array.data);
                    } else {
                        console.log(array.data);
                        var errorAlert = '<div class="alert alert-danger mt-3 mb-3" role="alert">' + array.data + '</div>';
                        $('#comment-alert-container').html(errorAlert);
                    }
                },
                error: function(error) {
                    console.log('AJAX request failed:', error);
                    alert('AJAX request failed. Please try again.');
                }
            });
        }
    });

    function addComment() {
        var c_content = $('#c_content').val();
        var c_ref_id = $('#inc_id').val();
        var c_task_type = "incident";
        var c_commentor_id = $('#pcd_id').val();

        var data = {
            "post_comment": 1,
            "c_content": c_content,
            "c_ref_id": c_ref_id,
            "c_task_type": c_task_type,
            "c_commentor_id": c_commentor_id
        };

        $.ajax({
            url: 'admin_incident_add_comment.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                var array = (typeof response === 'string') ? JSON.parse(response) : response;

                console.log(array); // Debugging: Check the structure of the response

                if (array.success) {
                    console.log(array.data);
                    var successAlert = '<div class="alert alert-success mt-3 mb-3" role="alert">Comment Added!</div>';
                    $('#comment-alert-container').html(successAlert);
                    display_list_comment(array.data);

                } else {
                    console.log(array.data);
                    var errorAlert = '<div class="alert alert-danger mt-3 mb-3" role="alert">' + array.data + '</div>';
                    $('#comment-alert-container').html(errorAlert);
                }
            },
            error: function(error) {
                console.log('AJAX request failed:', error);
                alert('AJAX request failed. Please try again.');
            },
            complete: function() {
                $('#comment-loading-spinner').addClass('d-none');
            }
        });
    }

    function display_list_comment(comments) {
        // Ensure comments is an array
        if (!Array.isArray(comments)) {
            console.error('Comments data is not an array:', comments);
            return;
        }

        var card_design = '';

        comments.forEach(function(comment) {
            card_design += `
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <h5 class="card-title">${comment.pcd_name}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">${comment.duration}</h6>
                        <p class="card-text">${comment.c_content}</p>
                    </div>
                </div>
            `;
        });

        $('#comment-card-list').html(card_design);
    }

    document.addEventListener('DOMContentLoaded', manageEditIncTab);
</script>

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