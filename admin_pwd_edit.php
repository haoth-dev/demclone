<?php
session_start();
$ipage = true;
$title = "Patient";

//process
require_once("function/function.php");


if (isset($_GET['pt_id'])) {
    $patObj = new patient($_GET['pt_id']);
    $demObj = new dementia($patObj->data['pt_id']);
    $demTypeList = $demObj->list_all_dem_type();
    $careObj = new caregiver();
    $pcList = $careObj->list_primary_caregiver();
}

if (isset($_POST['edit'])) {
    $editPatObj = new patient();
    $result = $editPatObj->admin_update_patient_data_with_photo($_POST);
    if ($result) {
        $success = true;
        $patObj = new patient($_GET['pt_id']);
    } else {
        $sucess = false;
    }
    //view_array($_POST);

}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <?php
    if (!empty($_POST)) {
        if ($success) {
    ?>
            <div class="alert alert-success" role="alert">
                PWD Data Updated
            </div>
        <?php
        } else {
            $err = $editPatObj->e_log;
        ?>
            <div class="alert alert-danger" role="alert">
                <b><?php echo $err;  ?></b>
            </div>
    <?php
        }
    }
    ?>

    <h4>Update Patient Form</h4>


    <form id="contactForm" method='post' enctype="multipart/form-data">
        <input type=hidden name='pt_id' value=<?php echo $patObj->data['pt_id']; ?>>
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="file" name="pt_photo" required />
            <label for="icNumber">PWD Photo</label>

        </div>
        <?php
        if (!empty($pcList)) {
        ?>
            <div class="form-floating mb-3">
                <select class="form-select" id="pcd_id" aria-label="pcd_id" name=pcd_id>
                    <?php
                    foreach ($pcList as $value) {
                    ?>
                        <option <?php echo selection_equal($value['pcd_id'], $patObj->data['pcd_id']); ?> value="<?php echo $value['pcd_id'] ?>"><?php echo $value['pcd_name']; ?></option>
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
            <input class="form-control" id="icNumber" type="text" placeholder="Patient IC no" data-sb-validations="required" name="pt_ic" value=<?php echo $patObj->data['pt_ic']; ?> disabled>
            <label for="icNumber">IC Number</label>
            <div class="invalid-feedback" data-sb-feedback="icNumber:required">IC Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="pt_name" value="<?php echo $patObj->data['pt_name']; ?>">
            <label for="fullName">Full Name</label>
            <div class="invalid-feedback" data-sb-feedback="fullName:required">Full Name is required.</div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="pt_dob" value=<?php echo $patObj->data['pt_dob']; ?>>
            <label for="dob">DOB</label>
            <div class="invalid-feedback" data-sb-feedback="dob:required">DOB is required.</div>
        </div>


        <?php
        if (!empty($demTypeList)) {
        ?>
            <div class="form-floating mb-3">
                <select class="form-select" id="dt_id" aria-label="dt_id" name=dt_id>
                    <?php
                    foreach ($demTypeList as $value) {
                    ?>
                        <option <?php echo selection_equal($value['dt_id'], $patObj->data['dt_id']); ?> value="<?php echo $value['dt_id']; ?>"><?php echo $value['dt_name']; ?></option>
                    <?php

                    }
                    ?>

                </select>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pt_stage" value="<?php echo $patObj->data['pt_stage']; ?>" />
                <label for="contactNumber">stage</label>

            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                No Dementia Type added yet, please contact your admin to enter the Dementia type
            </div>
        <?php
        }
        ?>



        <div class="form-floating mb-3">
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pt_relationship" value="<?php echo $patObj->data['pt_relationship']; ?>">
            <label for="contactNumber">Relationship</label>
            <div class="invalid-feedback" data-sb-feedback="contactNumber:required">Contact Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" name="pt_location"><?php echo $patObj->data['pt_location']; ?></textarea>
            <label for="address">Address</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Remark" style="height: 10rem;" data-sb-validations="required" name="pt_remark"><?php echo $patObj->data['pt_remark']; ?></textarea>
            <label for="address">Remark</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>

        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Update</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="admin_pwd.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i>Back to Patient</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->