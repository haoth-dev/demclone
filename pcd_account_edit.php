<?php
session_start();
$ipage = true;
$title = "Account Details";

//process
require_once("function/function.php");

if (isset($_GET['pcd_id'])) {
    $cgObj = new caregiver($_GET['pcd_id']);
    $pcd_email = $cgObj->data['pcd_email'];
    $loginObj = new login($pcd_email);
    //  view_array($loginObj);
}

if (isset($_POST['update'])) {
    $loginPostObj = new login();
    $update_result = $loginPostObj->update_password($_POST['l_username'], $_POST['current_pass'], $_POST['new_pass'], $_POST['c_new_pass']);
    if (!$update_result) {
        $err = $loginPostObj->e_log;
    }
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Account Info</h4>
    <hr>
    <?php
    if (!empty($_POST)) { //kalau form kana submit
        if (empty($err)) { //kalau nada error - everything is ok
    ?>
            <div class="alert alert-success" role="alert">
                account password updated!
            </div>
        <?php

        } else { //kalau ada error
        ?>
            <div class="alert alert-danger" role="alert">
                <?php
                foreach ($err as $value) {
                ?>
                    <b><?php echo $value; ?></b>
                <?php
                }
                ?>
            </div>
    <?php
        }
    }
    ?>
    <form method="post">


        <input type="hidden" name="l_pass" value="<?php echo $loginObj->data['l_pass'] ?>">
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" data-sb-validations="required" name="l_username" value="<?php echo $loginObj->data['l_username'] ?>" readonly>
            <label for="icNumber">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="password" placeholder="Full Name" data-sb-validations="required" name="current_pass" required>
            <label for="fullName"> Current Password</label>

        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="password" placeholder="Full Name" data-sb-validations="required" name="new_pass" required>
            <label for="fullName"> New Password</label>

        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="password" placeholder="Full Name" data-sb-validations="required" name="c_new_pass" required>
            <label for="fullName">Confirm Password</label>

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

<?php

require_once("sub/footer.php");
?>