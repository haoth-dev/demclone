<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");
//view_array($_SESSION);
$medsObj = new medication();
$medsList = $medsObj->list_meds_by_pcd($_SESSION['pcd_id']);
view_array($medsList);

//header
require_once("sub/header.php");

//content
?>


  <div class="container">
 
   <h4>Admin Console</h4>
   <br>
   <?php
        if(!empty($medsList)){

            foreach ($medsList as $value) {
                ?>
                
                <div class="card">
                  <h5 class="card-header"><?php echo $value['meds_name'] ?></h5>
                  <div class="card-body">
                      <h5 class="card-title">Meds Remark</h5>
                      <p class="card-text"><?php echo $value['meds_desc'] ?></p>
                      <a href="#" class="btn btn-primary">Edit Meds</a>
                  </div>
                </div>
                <br>
              <?php
            }
          
        }
        else{
            echo "<h3>No medication Added yet...</h3>";
        }
   ?>
      
    <br>
     
  


  </div>
   <br>
   <a href="medication_add.php" class="btn btn-primary floating-button">
    <i class="fas fa-plus"></i>
  </a>


  </div>
<?php

require_once("sub/footer.php");
?>
