<?php
session_start();
$ipage = true;
$title = "Guest Register";

//process
require_once("function/function.php");
if (isset($_GET['pt_id'])) {
    $patObj = new patient($_GET['pt_id']);
}




//view_array($patObj->data);

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h3>Guest Registration</h3>
        </div>
        <div class="card-body">
            <div id="alertContainer"></div>
            <form id="registrationForm">
                <div class="floating-label">
                    <input type="text" class="form-control" id="pcd_name" name="pcd_name" placeholder=" " required>
                    <label for="pcd_name">Name</label>
                </div>
                <div class="floating-label">
                    <input type="tel" class="form-control" id="pcd_contact" name="pcd_contact" placeholder=" " required>
                    <label for="pcd_contact">Contact Number</label>
                </div>
                <div class="floating-label">
                    <input type="email" class="form-control" id="pcd_email" name="pcd_email" placeholder=" " required>
                    <label for="pcd_email">Email Address</label>
                </div>
                <div class="floating-label">
                    <textarea class="form-control" id="address" placeholder=" " style="height: 10rem;" name="mp_remark"></textarea>
                    <label for="address">Remark - address remark / Missing person remark</label>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="hidden" id="pt_id" name="pt_id" value="<?php echo @$_GET['pt_id']; ?>">
                <input type="hidden" id="pcd_id" name="pcd_id" value="<?php echo @$patObj->data['pcd_id'] ?>">
                <div class="d-grid">
                    <button type="button" class="btn btn-primary btn-block" onclick="getLocation()">Register and Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="resource/js/guest.js"></script>
<?php

require_once("sub/footer.php");
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>