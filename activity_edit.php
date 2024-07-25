<?php
session_start();
$ipage = true;
$title = "Activity Edit";

//process
require_once("function/function.php");
//view_array($_SESSION);
if(isset($_GET['act_id'])){
$actObj = new activity($_GET['act_id']);
$atObj = new actype(); 
$atList = $atObj->list_all_actype();
}

if(isset($_POST['edit'])){
    //view_array($_POST);
    $postObj = new activity();
    $result = $postObj->update_activity_details($_POST);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $postObj->e_log;
        $success = false;
    }
}

//header
require_once("sub/header.php");

//content
?>


  <div class="container">
  <div class="form-floating row">
        <div class="col-2">
          <a href="activity_detail.php?act_id=<?php echo $_GET['act_id']; ?>" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
        </div>
      </div>
  <h4 >Activity Edit Form</h4>
  <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Edit Activity", @$err);
        $actObj = new activity($_POST['act_id']);
    }
    ?>
 
  <form id="contactForm" method='post' enctype="multipart/form-data" >
        <input type="hidden" name="pcd_id" value="<?php echo $actObj->data['pcd_id']; ?>">
        <input type="hidden" name="pt_id" value="<?php echo $actObj->data['pt_id']; ?>">
        <input type="hidden" name="act_id" value="<?php echo $actObj->data['act_id']; ?>">
        <?php
        if (!empty($atList)) {
        ?>
            <div class="input-group mb-3 mt-3">
                <label class="input-group-text" for="inputGroupSelect01">Type</label>
                <select class="form-select" name="at_id">
                    <?php
                    foreach ($atList as $value) {
                    ?>
                        <option <?php echo selection_equal($value['at_id'], $actObj->data['at_id']) ?> value="<?php echo $value['at_id'] ?>"><?php echo $value['at_name'] ?></option>
                    <?php

                    }
                    ?>
                </select>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                No inc type added yet, Please email your admin at dementiabn@dementiabn.xyz
            </div>
        <?php
        }
        ?>

<div class="form-floating mb-3">
            <input class="form-control" step="any" type="datetime-local" placeholder="Date and time" name="act_datetime" value="<?php echo $actObj->data['act_datetime']; ?>" />
            <label >Activity Date & Time</label>

        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Activity Name"  name="act_name" value="<?php echo $actObj->data['act_name'] ?>" required/>
            <label >Activity Name</label>

        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;"  name="act_desc" required><?php echo $actObj->data['act_desc'] ?></textarea>
            <label for="address">Activity Type Description</label>
           
        </div>

    



        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Edit </button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="activity.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Activity List</a>
            </div>
        </div>




    </form>

  </div>
<?php

require_once("sub/footer.php");
?>
