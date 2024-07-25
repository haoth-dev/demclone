<?php
session_start();
$ipage = true;
$title = "Add Activity";

//process
require_once("function/function.php");

$atObj = new actype();

$atList = $atObj->list_all_actype();

if (isset($_GET['pt_id'])) {
    $patObj = new patient($_GET['pt_id']);
}

if (isset($_POST['add'])) {
    $actObj = new activity();
    $result = $actObj->insert_activity($_POST);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $atObj->e_log;
        $success = false;
    }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Add New Activity</h4>

    <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Add New Activity", @$err);
    }
    ?>


    <form id="contactForm" method='post' enctype="multipart/form-data">
        <input type="hidden" name="pcd_id" value="<?php echo $patObj->data['pcd_id']; ?>">
        <input type="hidden" name="pt_id" value="<?php echo $patObj->data['pt_id']; ?>">
        <input type="hidden" name="act_datetime" value="<?php echo servDate(); ?>">
        <?php
        if (!empty($atList)) {
        ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Type</label>
                <select class="form-select" name="at_id">
                    <?php
                    foreach ($atList as $value) {
                    ?>
                        <option value="<?php echo $value['at_id'] ?>"><?php echo $value['at_name'] ?></option>
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
            <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="act_name" />
            <label for="icNumber">Activity Name</label>

        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="act_desc"></textarea>
            <label for="address">Activity Type Description</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add">Add </button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="activity.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Activity List</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->