<?php
session_start();
$ipage = true;
$title = "Admin Add PWD";

//process
require_once("function/function.php");

$demObj = new dementia();
$demTypeList = $demObj->list_all_dem_type();
$careObj = new caregiver();
$pcList = $careObj->list_primary_caregiver();



if (isset($_POST['register'])) {
    //view_array($_POST);
    $patientObj = new patient();
    $result = $patientObj->insert_patient_admin($_POST);
    if ($result) {
        alert("New Patient Added");
    } else {

        alert("New Patient Failed add");
    }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Add Dementia person Form</h4>


    <form method="post" enctype="multipart/form-data">
        <?php
        if (!empty($pcList)) {
        ?>
            <div class="form-floating mb-3">
                <select class="form-select" id="dt_id" aria-label="dt_id" name=pcd_id>
                    <?php
                    foreach ($pcList as $value) {
                    ?>
                        <option value="<?php echo $value['pcd_id'] ?>"><?php echo $value['pcd_name']; ?></option>
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
            <input class="form-control" id="icNumber" type="file" name="pt_photo" />
            <label for="icNumber">PWD Photo</label>

        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Patient IC no" data-sb-validations="required" name="pt_ic" />
            <label for="icNumber">IC Number</label>
            <div class="invalid-feedback" data-sb-feedback="icNumber:required">IC Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="pt_name" />
            <label for="fullName">Full Name</label>
            <div class="invalid-feedback" data-sb-feedback="fullName:required">Full Name is required.</div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="pt_dob" />
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
                        <option value="<?php echo $value['dt_id'] ?>"><?php echo $value['dt_name']; ?></option>
                    <?php

                    }
                    ?>

                </select>
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
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pt_stage" />
            <label for="contactNumber">stage</label>
            <div class="invalid-feedback" data-sb-feedback="contactNumber:required">Contact Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pt_relationship" />
            <label for="contactNumber">Relationship</label>
            <div class="invalid-feedback" data-sb-feedback="contactNumber:required">Contact Number is required.</div>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Remark" style="height: 10rem;" data-sb-validations="required" name="pt_location"></textarea>
            <label for="address">Address</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Remark" style="height: 10rem;" data-sb-validations="required" name="pt_remark"></textarea>
            <label for="address">Remark</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>


        <div class="d-none" id="submitErrorMessage">
            <div class="text-center text-danger mb-3">Error sending message!</div>
        </div>
        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="register">Register</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="admin_pwd.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Back to Patient</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->