<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");
if (isset($_POST['add'])) {
  $pmedsObj = new medication();
  $result = $pmedsObj->insert_medication($_POST);
  if (!empty($result)) {
    $success = true;
  } else {
    $err = $pmedsObj->e_log;
    $success = false;
  }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
  <br>
  <h4>Add Medication Form</h4>
  <?php
  if (!empty($_POST)) {
    success_alert(@$success, "Successfully Add New Medication", @$err);
  }
  ?>


  <form id="contactForm" method='post'>

    <div class="form-floating mb-3">
      <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="meds_name" />
      <label for="icNumber">Medication Name</label>
      <div class="invalid-feedback" data-sb-feedback="icNumber:required">IC Number is required.</div>
    </div>
    <div class="form-floating mb-3">
      <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="meds_desc"></textarea>
      <label for="address">Medication Remark</label>
      <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
    </div>




    <div class="form-floating row mb-3">
      <div class="col-12">
        <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add">Add Meds</button>
      </div>
    </div>

    <div class="form-floating row">
      <div class="col-12 ">
        <a href="medication.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Meds Page</a>
      </div>
    </div>




  </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->