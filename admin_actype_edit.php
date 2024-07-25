<?php
session_start();
$ipage = true;
$title = "Admin Add Activity Type";

//process
require_once("function/function.php");

if (isset($_GET['at_id'])) {
    $getAtObj = new actype($_GET['at_id']);
}

if (isset($_POST['edit'])) {
    $atObj = new actype();
    $result = $atObj->update_actype($_POST);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $atObj->e_log;
        $success = false;
    }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Edit Activity Type</h4>

    <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Edit Activity Type", @$err);
    }
    ?>


    <form id="contactForm" method='post' enctype="multipart/form-data">
        <input type="hidden" name="at_id" value="<?php echo $_GET['at_id'] ?>">
        <div class="form-floating mb-3">
            <input class="form-control" id="photo" type="file" name="icon_image" required />
            <label for="icNumber">Icon</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Activity Type Name" data-sb-validations="required" name="at_name" value="<?php echo $getAtObj->data['at_name']; ?>" />
            <label for="icNumber">Activity Type Name</label>

        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Description" style="height: 10rem;" data-sb-validations="required" name="at_desc"><?php echo $getAtObj->data['at_desc']; ?></textarea>
            <label for="address">Activity Type Description</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="edit">Edit </button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="admin_actype.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Activity Type List</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->