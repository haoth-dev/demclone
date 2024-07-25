<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");
//view_array($_SESSION);
$medsObj = new medication();
$medsList = $medsObj->list_meds_by_pcd($_SESSION['pcd_id']);
//view_array($medsList);

if (isset($_POST['ajax_detail_btn'])) {
  $response = array();
  $medsDetailObj = new medication($_POST['ajax_meds_id']);
  $response['medsData'] = $medsDetailObj->data;
  $response['success'] = true;
  echo json_encode($response);
  exit();
}


if (isset($_POST['ajax_modal_btn'])) {
  $response = array();
  $medsDetailObj1 = new medication($_POST['ajax_meds_id']);
  $response['medsData'] = $medsDetailObj1->data;
  $response['success'] = true;

  echo json_encode($response);
  exit();
}
//header
require_once("sub/header.php");

//content
?>


<div class="container">
  <div class="form-floating row">
    <div class="col-2">
      <a href="nav_page.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
    </div>
  </div>
  <h4>Medication</h4>

  <div class="table-responsive-sm">
    <table class=table>
      <thead>
        <th>#</th>
        <th>Name</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if (!empty($medsList)) {
          foreach ($medsList as $value) {
        ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $value['meds_name']; ?></td>
              <td> <a href="medication_edit.php?meds_id=<?php echo $value['meds_id'] ?>" class="btn btn-primary"> <i class="fas fa-edit"></i></a></td>

            </tr>
          <?php
            $no++;
          }
        } else {
          ?>

          <div class="alert alert-warning" role="alert">
            No Medication added yet
          </div>
        <?php

        }

        ?>
      </tbody>

    </table>
  </div>




  <br>
  <a href="medication_add.php" class="btn btn-primary floating-button">
    <i class="fas fa-plus"></i>
  </a>


</div>

<?php

require_once("sub/footer.php");
?>