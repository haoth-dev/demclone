<?php
session_start();
$ipage = true;
$title = "Register";

// Process dependencies
require_once("function/function.php");

if (isset($_GET['pcd_id'])) {
    $scaregiverDetail = new caregiver($_GET['pcd_id']);
    $loginObj = new login($scaregiverDetail->data['pcd_email']);
}


if (isset($_POST['edit'])) {
    $cgObj = new caregiver();
    $update = $cgObj->update_caregiver_data($_POST);
    if ($update) {
        $success = true;
    } else {
        $err = $cgObj->e_log;
        $success = false;
    }
}

// Include header
require_once("sub/header.php");
?>

<div class="container">
    <br>
    <div class="form-floating row">
        <div class="col-2">
            <a href="support.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Personal</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Account</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <?php
            if (!empty($_POST['edit'])) {
                success_alert($success, "Successfully updated secondary caregiver data", @$err);
                $scaregiverDetail = new caregiver($_GET['pcd_id']);
            }
            ?>
            <br>
            <h3>Details Form</h3>
            <form method='post' enctype="multipart/form-data">
                <input type="hidden" name="pcd_assign_id" value="<?php echo htmlspecialchars($_SESSION['pcd_id']); ?>">
                <input type="hidden" name="pcd_id" value="<?php echo htmlspecialchars($_GET['pcd_id']); ?>">
                <input type="hidden" name="pcd_email" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_email']); ?>">
                <div class="form-floating mb-3">
                    <input class="form-control" type="file" name="caregiver_photo" required />
                    <label for="icNumber">Profile Photo</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="icNumber" type="text" placeholder="IC Number" data-sb-validations="required" name="pcd_ic" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_ic']); ?>">
                    <label for="icNumber">IC Number</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="pcd_name" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_name']); ?>">
                    <label for="fullName">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="pcd_dob" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_dob']); ?>">
                    <label for="dob">DOB</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="contactNumber" type="text" placeholder="Contact Number" data-sb-validations="required" name="pcd_contact" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_contact']); ?>">
                    <label for="contactNumber">Contact Number</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="address" type="text" placeholder="Address" style="height: 10rem;" data-sb-validations="required" name="pcd_addr"><?php echo htmlspecialchars($scaregiverDetail->data['pcd_addr']); ?></textarea>
                    <label for="address">Address</label>
                </div>
                <br>
                <div class="form-floating row mb-3">
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Edit</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <br>
            <h4>Login Account Info</h4>
            <hr>

            <!-- Alert Container -->
            <div id="alert-container"></div>
            <!-- Loading Spinner -->
            <div id="loading-spinner" class="d-none">
                <div class="spinner-grow" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>


            <input type="hidden" id="l_pass" name="l_pass" value="<?php echo htmlspecialchars($loginObj->data['l_pass']); ?>">
            <div class="form-floating mb-3">
                <input class="form-control" id="l_username" type="email" placeholder="Email Address" data-sb-validations="required,email" name="l_username" value="<?php echo htmlspecialchars($scaregiverDetail->data['pcd_email']); ?>" readonly />
                <label for="emailAddress">Email Address</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" placeholder="Current Password" id="current_pass" data-sb-validations="required" name="current_pass" required>
                <label for="current_pass">Current Password</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" placeholder="New Password" id="new_pass" data-sb-validations="required" name="new_pass" required>
                <label for="new_pass">New Password</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" placeholder="Confirm New Password" id="c_new_pass" data-sb-validations="required" name="c_new_pass" required>
                <label for="c_new_pass">Confirm New Password</label>
            </div>
            <div class="form-floating row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary btn-lg btn-block std-btn" id="update_account" name="update_account" onclick="scd_account_update()">Update</button>
                </div>
            </div>

        </div>
    </div>

    <script>

    </script>
    <script src="resource/js/caregiver.js"></script>
</div>

<?php
require_once("sub/footer.php");
?>