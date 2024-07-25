<?php
session_start();
$ipage = true;
$title = "Profile";

//process
require_once("function/function.php");
if (isset($_SESSION)) {
  //view_array($_SESSION);

  $pcObj = new login($_SESSION['pcd_id']);
  $detail = new caregiver($_SESSION['pcd_id']);
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">

  <div class="form-floating row">
    <div class="col-12 ">
      <a href="index.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i></a>
    </div>
  </div>
  <h4>My Profile</h4>

  <div class="container py-4">
    <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3">
      <div class="col">
        <div class="card">

          <div class="text-center">
            <img src="<?php echo $detail->data['pcd_photo_path'];  ?>" class="rounded img-fluid" height=400 width=400>
          </div>



          <div class="card-body">
            <h5 class="card-title">Personal Info</h5>
            <table class=table>
              <tr>
                <td>IC:</td>
                <td><?php echo $detail->data['pcd_ic']  ?></td>
              </tr>
              <tr>
                <td>Name:</td>
                <td><?php echo $detail->data['pcd_name']  ?></td>
              </tr>
              <tr>
                <td>DOB:</td>
                <td><?php echo $detail->data['pcd_dob']; ?></td>
              </tr>
              <tr>
                <td>Contact:</td>
                <td><?php echo $detail->data['pcd_contact']; ?></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><?php echo $detail->data['pcd_email']; ?></td>
              </tr>
              <tr>
                <td>Address:</td>
                <td><?php echo $detail->data['pcd_addr']; ?></td>
              </tr>
            </table>


          </div>
          <div class="card-footer">
            <div class="d-grid gap-2">
              <a href="profile_edit.php?pcd_id=<?php echo $detail->data['pcd_id'] ?>" class="btn btn-primary">Update Personal Info</a>
              <a href="pcd_account_edit.php?pcd_id=<?php echo $detail->data['pcd_id'] ?>" class="btn btn-primary">Update Account</a>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->