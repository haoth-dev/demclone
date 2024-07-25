<?php
session_start();
$ipage = true;
$title = "Patient";

//process
require_once("function/function.php");
$alert = "";
if(isset($_GET['meds_id'])){
  $medsDetails = new medication($_GET['meds_id']);
    //view_array($_SESSION);
}

if(isset($_POST['edit'])){
  $editMedDetails = new medication();
  $result = $editMedDetails->update_medication($_POST);
  if($result){
   $alert = "<div class='alert alert-success' role='alert'>Update sucess</div>";
  }
  else{
    $alert = "<div class='alert alert-danger' role='alert'>Update failed</div>";
  }
  $medsDetails = new medication($_GET['meds_id']);
}


//header
require_once("sub/header.php");

//content
?>


  <div class="container">
 <br>
   <h4>Edit Medication Form</h4>

    <?php 
     if(@$alert != ""){
      echo $alert;
     }
    ?>
   <form id="contactForm" method='post'>
      <input type="hidden" name=meds_id value="<?php echo $medsDetails->data['meds_id'] ?>">
        <div class="form-floating mb-3">
            <input class="form-control"  type="text" placeholder="Meds Name" data-sb-validations="required" name="meds_name" value="<?php echo $medsDetails->data['meds_name'] ?>">
            <label for="icNumber">Medication Name</label>
            <div class="invalid-feedback" data-sb-feedback="icNumber:required">IC Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="meds_desc"><?php echo $medsDetails->data['meds_desc'] ?></textarea>
            <label for="address">Medication Remark</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Description is required.</div>
        </div>
    

 
   
        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit" <?php echo $medsDetails->disabled_edit_meds_btn_verified($_SESSION['pcd_id'],$medsDetails->data['meds_id']); ?>>Edit</button>
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
