<?php
session_start();
$ipage = true;
$title = "Patient";

//process
require_once("function/function.php");
//view_array($_SESSION);
//view_array($_SESSION);
$patObj = new patient();
$patList = $patObj->list_all_patient_by_pcdID($_SESSION['pcd_id']);
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
    <button class="nav-link" id="nav-ca-tab" data-bs-toggle="tab" data-bs-target="#nav-ca" type="button" role="tab" aria-controls="nav-cae" aria-selected="false">Caregiver </button>
    <button class="nav-link" id="nav-meds-tab" data-bs-toggle="tab" data-bs-target="#nav-meds" type="button" role="tab" aria-controls="nav-meds" aria-selected="false">Medication</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-home-tab">
    <br>
  <?php
        if(!empty($patList)){

            foreach ($patList as $value) {
                ?>
                
                <div class="card">
                  <h5 class="card-header"><?php echo $value['pt_name'] ?></h5>
                  <div class="card-body">
                      <h5 class="card-title"> Info</h5>
                      <p class="card-text"><?php echo $value['pt_remark'] ?></p>
                      <a href="patient_edit.php?pt_id=<?php echo $value['pt_id'] ?>" class="btn btn-primary">Edit </a>
                  </div>
                </div>
                <br>
              <?php
            }
          
        }
        else{
            echo "<h3>No Dementia People Added yet...</h3>";
        }
   ?>
  </div>
  <div class="tab-pane fade" id="nav-ca" role="tabpanel" aria-labelledby="nav-ca-tab">
    <br>
  <?php
        if(!empty($patList)){

            foreach ($patList as $value) {
                ?>
                
                <div class="card">
                <input type="hidden" class="pt_id_val" value="<?php echo $value['pt_id']; ?>">
                  <h5 class="card-header"><?php echo $value['pt_name'] ?></h5>
                  <div class="card-body">
                
                  <table class=table>
                    <thead>
                      <th>no</th>
                      <th>Name</th>
                      <th>Assign</th>
                      <th>Remove</th>
                    </thead>

                    <tbody>
                      <?php
                      $counter=1; 
                          if(!empty($scList)){
                            $scObj2 = new caregiver();
                            
                            foreach($scList as $value2){
                              ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $value2['pcd_name'] ?></td>
                                <td>
                                  <input type="hidden" class="pcsc_status_val" value="<?php  echo $scObj2->pcsc_status_btn_check($value2['pcd_id'], $value['pt_id']); ?>" >
                                  <input type="hidden" class="pcd_id_val" value="<?php echo $value2['pcd_id']; ?>">
                                  <button class="btn btn-outline-info" onclick="assign_sc(this)">
                                      <i class="fa <?php echo $scObj2->pcsc_status_btn_toggle($value2['pcd_id'],$value['pt_id']); ?>" aria-hidden="true"></i>
                                  </button>
                                </td>
                                <td>
                                 <button class="btn btn-outline-danger" onclick="delete_sc(this)">
                                      <i class="fa fa-times" aria-hidden="true" ></i>
                                  </button>
                                </td>
                               
                            </tr>
                            <?php
                              $counter++;
                            }
                           
                            
                          }
                          else{
                              echo "<h3>No Secondary caregiver Added yet...</h3>";
                          }
                      ?>
                    

                

                    </tbody>
                  </table>
                    
                  </div>
                </div>
                <br>
              <?php
            }
          
        }
        else{
            echo "<h3>No Secondary caregiver Added yet......</h3>";
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
            echo "<h3>No Medication Added yet...</h3>";
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
