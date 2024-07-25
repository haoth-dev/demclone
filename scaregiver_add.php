<?php
session_start();
$ipage = true;
$title = "Register";

//process
require_once("function/function.php");

if (isset($_POST['register'])) {
    $scaregiverObj = new caregiver();
    $add_scaregiver = $scaregiverObj->insert_scaregiver($_POST);
    if ($add_scaregiver) {
        $success = true;
    } else {
        $err = $scaregiverObj->e_log;
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
    if (!empty($_POST)) {
        if ($success) {
    ?>
            <div class="alert alert-success" role="alert">
                Secondary Caregiver added!!
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

    <h4>Personal Info</h4>
    <hr>

    <form method='post' enctype="multipart/form-data">
        <input type="hidden" name="pcd_assign_id" value=<?php echo $_SESSION['pcd_id'] ?>>
        <div class="form-floating mb-3">
            <input class="form-control" type="file" name="profile_photo" />
            <label for="icNumber">Profile Photo</label>

        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="IC Number" data-sb-validations="required" name="ic" />
            <label for="icNumber">IC Number</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="fullname" />
            <label for="fullName">Full Name</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="dob" />
            <label for="dob">DOB</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="contactno" />
            <label for="contactNumber">Contact Number</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" name="address"></textarea>
            <label for="address">Address</label>
        </div>
        <br>
        <h4>Login Account Info </h4>
        <hr>
        <div class="form-floating mb-3">
            <input class="form-control" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" name="email" />
            <label for="emailAddress">Email Address</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="password" type="password" placeholder="Password" data-sb-validations="required" name="password" />
            <label for="password">Password</label>
        </div>

        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="register">Add Secondary Caregiver</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="index.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Home</a>
            </div>
        </div>
</div>






</form>





</div>
<?php

require_once("sub/footer.php");
?>