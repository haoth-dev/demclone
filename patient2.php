<?php
session_start();
$ipage = true;
$title = "Patient";

//process
require_once("function/function.php");
//view_array($_SESSION);
//view_array($_SESSION);
$patObj = new patient();
$patList = $patObj->list_all_patient_by_scdID($_SESSION['pcd_id']);
//view_array($patList);
$scObj = new caregiver();
$scList = $scObj->list_secondary_caregiver($_SESSION['pcd_id']);
//view_array($scList);

if(isset($_POST['ajax_assign_btn'])){
    $assignObj = new caregiver();
    $response = array();
    $_POST['pcd_id'] = $_SESSION['pcd_id'];
    $result = $assignObj->pcsc_status_update($_POST);
    $assignObj = new caregiver();
    $response['success'] = true;
    $response['data'] = $result;
    echo json_encode($response);//array respon ane th yg d antar ke ajax balik.
    exit();
   
}
//header
require_once("sub/header.php");

//content
?>


  <div class="container">
    
 <br>
   <h4>People With Dementia</h4>

   <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">Info</button>
   
    <button class="nav-link" id="nav-meds-tab" data-bs-toggle="tab" data-bs-target="#nav-meds" type="button" role="tab" aria-controls="nav-meds" aria-selected="false">Medication</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-home-tab">
    <br>
  <?php
        if(!empty($patList)){

            foreach ($patList as $value) {
                $patData = new patient($value['pt_id']);
                ?>
                <div class="card">
                  <h5 class="card-header"><?php echo $patData->data['pt_name'] ?></h5>
                  <div class="card-body">
                      <h5 class="card-title">Patient Info</h5>
                      <p class="card-text"><?php echo $patData->data['pt_remark'] ?></p>
                     
                  </div>
                </div>
                <br>
              <?php
            }
          
        }
        else{
            echo "<h3>No Dementia person Added yet...</h3>";
        }
   ?>
  </div>

  <div class="tab-pane fade" id="nav-meds" role="tabpanel" aria-labelledby="nav-meds-tab">
            <br>
            <?php
        if(!empty($patList)){

            foreach ($patList as $value) {
                $patData = new patient($value['pt_id']);
                ?>
                <div class="card">
                  <h5 class="card-header"><?php echo $patData->data['pt_name'] ?></h5>
                  <div class="card-body">
                      <h5 class="card-title">Medication List</h5>
                      <p class="card-text">1. Panadol - 2 times a day</p>
                      <p class="card-text">2. Ibuprofen - take when needed</p>
                      <p class="card-text">3. Gaviscon - 3 times a day</p>
                     
                  </div>
                </div>
                <br>
              <?php
            }
          
        }
        else{
            echo "<h3>No Dementia person Added yet...</h3>";
        }
   ?>


  </div>
</div>
  
    
    <?php 
          if($_SESSION['pcd_level'] != 'secondary'){
              ?>
                <a href="patient_add.php" class="btn btn-primary floating-button">
    <i class="fas fa-plus"></i>
  </a>
              <?php 
          }
    ?>
 


  </div>
  <script src="resource/js/patient.js"></script>
<?php

require_once("sub/footer.php");
?>
 <!-- Font Awesome -->
