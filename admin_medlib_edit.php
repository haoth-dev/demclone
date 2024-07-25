<?php
session_start();
$ipage = true;
$title = "Admin - Edit Meds";

//process
require_once("function/function.php");
$alert = "";
$careObj = new caregiver();

$backpage = "admin_medlib.php";

if (isset($_GET['meds_id'])) {
    $medsDetails = new medication($_GET['meds_id']);
    $pcList = $careObj->list_primary_caregiver($medsDetails->data['pcd_id']);
    //view_array($_SESSION);
}

if (isset($_GET['page'])) {
    $backpage = "admin_medlib_search.php";
}

if (isset($_POST['edit'])) {
    $postMedsObj = new medication();
    $result = $postMedsObj->validated_admin_update_medication($_POST);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $postMedsObj->e_log;
        $success = false;
    }
    $medsDetails = new medication($_GET['meds_id']);
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Edit Medication Form</h4>

    <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Edit Medication", @$err);
    }
    ?>
    <form id="contactForm" method='post'>
        <input type="hidden" name=meds_id value="<?php echo $medsDetails->data['meds_id'] ?>">
        <?php
        if (!empty($pcList)) {
        ?>
            <div class="form-floating mb-3">
                <select class="form-select" id="pcd_id" aria-label="pcd_id" name=pcd_id>
                    <?php
                    foreach ($pcList as $value) {
                    ?>
                        <option <?php echo selection_equal($value['pcd_id'], $medsDetails->data['pcd_id']); ?> value="<?php echo $value['pcd_id'] ?>"><?php echo $value['pcd_name']; ?></option>
                    <?php

                    }
                    ?>

                </select>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                No caregiver added yet, Please add caregiver under user management
            </div>
        <?php
        }
        ?>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" placeholder="Meds Name" data-sb-validations="required" name="meds_name" value="<?php echo $medsDetails->data['meds_name'] ?>">
            <label for="icNumber">Medication Name</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="meds_desc"><?php echo $medsDetails->data['meds_desc'] ?></textarea>
            <label for="address">Medication Remark</label>
        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Edit</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="<?php echo $backpage; ?>" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Back to Meds Page</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->