<?php
session_start();
$ipage = true;
$title = "Register";

//process
require_once("function/function.php");


if (isset($_POST['register'])) {
    $caregiverObj = new caregiver();
    $add_caregiver = $caregiverObj->insert_pcaregiver_with_photo($_POST);
    if ($add_caregiver) {
        $success = true;
    } else {
        $err = $caregiverObj->e_log;
        $success = false;
    }
    //view_array($_POST);
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>


    <h4>Personal Info</h4>
    <hr>
    <?php
    if (!empty($_POST)) {
        if ($success) {
    ?>
            <div class="alert alert-success" role="alert">
                Account registration completed
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php
                foreach ($err as $value) {
                ?><b><?php echo $value[0] ?></b> <?php
                                                }
                                                    ?>
            </div>
    <?php
        }
    }
    ?>
    <form method='post' enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input class="form-control" id="photo" type="file" name="caregiver_photo" required />
            <label for="icNumber">Photo</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="IC Number" name="pcd_ic" required />
            <label for="icNumber">IC Number</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" name="pcd_name" required />
            <label for="fullName">Full Name</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" name="pcd_dob" required />
            <label for="dob">DOB</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" name="pcd_contact" required />
            <label for="contactNumber">Contact Number</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Address" style="height: 10rem;" name="pcd_addr" required></textarea>
            <label for="address">Address</label>
        </div>
        <br>
        <h4>Login Account Info </h4>
        <hr>
        <div class="form-floating mb-3">
            <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" name="pcd_email" required />
            <label for="emailAddress">Email Address</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="password" type="password" placeholder="Password" name="password" required />
            <label for="password">Password</label>
        </div>
        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="register">Register</button>
            </div>
        </div>

</div>

</form>




</div>
<?php

require_once("sub/footer.php");
?>