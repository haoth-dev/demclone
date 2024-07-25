<?php
session_start();
$ipage = true;
$title = "update data";

//process
require_once("function/function.php");

if (isset($_GET['pcd_id'])) {
    $getObj = new caregiver($_GET['pcd_id']);
}


if (isset($_POST['update'])) {

    $caregiverObj = new caregiver();
    $result = $caregiverObj->update_caregiver_data($_POST);
    if ($result) {
        $success = true;
    } else {
        $success = false;
    }
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <?php
    if (!empty($success)) {
        if (@$success) {
    ?>
            <div class="alert alert-success" role="alert">
                Profile success updated!
            </div>
        <?php
            $getObj = new caregiver($_GET['pcd_id']);
        } else {
        ?>
            <div class="alert alert-danger" role="alert">
                Failed to update profile, please contact your admin.
            </div>
    <?php
        }
    }

    ?>

    <h4>Personal Info</h4>
    <hr>

    <form method='post' enctype="multipart/form-data">
        <input type="hidden" name="pcd_id" value="<?php echo $_GET['pcd_id']; ?>">
        <div class="form-floating mb-3">
            <input class="form-control" id="photo" type="file" name="caregiver_photo" required />
            <label for="icNumber">Photo</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="IC Number" data-sb-validations="required" name="pcd_ic" value="<?php echo $getObj->data['pcd_ic'] ?>">
            <label for="icNumber">IC Number</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="pcd_name" value="<?php echo $getObj->data['pcd_name'] ?>">
            <label for="fullName">Full Name</label>

        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="pcd_dob" value="<?php echo $getObj->data['pcd_dob'] ?>">
            <label for="dob">DOB</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pcd_contact" value="<?php echo $getObj->data['pcd_contact'] ?>">
            <label for="contactNumber">Contact Number</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" name="pcd_addr"><?php echo $getObj->data['pcd_addr'] ?></textarea>
            <label for="address">Address</label>
        </div>


        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="update">Update </button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="profile.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Profile</a>
            </div>
        </div>
    </form>

</div>





</form>





</div>
<?php

require_once("sub/footer.php");
?>