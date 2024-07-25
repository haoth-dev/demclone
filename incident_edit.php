<?php
session_start();
$ipage = true;
$title = "Edit Incident";

//process
require_once("function/function.php");

$itObj = new inctype();
$itList = $itObj->list_all_inc_type();

if (isset($_GET['inc_id'])) {
    $incGetObj = new incident($_GET['inc_id']);
}

if (isset($_POST['edit'])) {
    $incObj = new incident();
    $_POST['inc_caller'] = $_SESSION['pcd_email'];

    $clean_post = $incObj->sanitize_post_data($_POST);
    $result = $incObj->update_incident($clean_post);
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
                        <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Edit Incident</button>
                    </div>
                </div>

                <div class="form-floating row">
                    <div class="col-12">
                        <a href="incident.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Incident Page</a>
                    </div>
                </div>
            </form>
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
              <!-- Alert Container -->
              <div id="activity-comment-alert-container"></div>
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
                url: 'incident_get_comment.php',
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
            url: 'incident_add_comment.php',
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