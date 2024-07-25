<?php
session_start();
$ipage = true;
$title = "Admin Medication";

//process
require_once("function/function.php");
$careObj = new caregiver();
$pcList = $careObj->list_primary_caregiver();
if (isset($_POST['add'])) {
    $pmedsObj = new medication();
    $result = $pmedsObj->admin_insert_medication($_POST);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $pmedsObj->e_log;
        $success = false;
    }
    // view_array($err);
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

    <form method='post'>
        <?php
        if (!empty($pcList)) {
        ?>
            <div class="form-floating mb-3">
                <select class="form-select" id="pcd_id" aria-label="pcd_id" name=pcd_id>
                    <?php
                    foreach ($pcList as $value) {
                    ?>
                        <option value="<?php echo $value['pcd_id'] ?>"><?php echo $value['pcd_name']; ?></option>
                    <?php

                    }
                    ?>

                </select>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning" role="alert">
                No caregiver added yet, Please add caregiver under user management
            </div>
        <?php
        }
        ?>
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="meds_name" />
            <label for="icNumber">Medication Name</label>

        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="meds_desc"></textarea>
            <label for="address">Medication Remark</label>

        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add">Add</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="admin_medlib.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Back to Meds Page</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->