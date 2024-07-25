<?php
session_start();
$ipage = true;
$title = "Admin Add Activity Type";

//process
require_once("function/function.php");



if (isset($_POST['add'])) {
    $atObj = new actype();
    $result = $atObj->insert_actype($_POST);
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
    <h4>Add New Activity Type</h4>

    <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Add New Activity Type", @$err);
    }
    ?>


    <form id="contactForm" method='post' enctype="multipart/form-data">

        <div class="form-floating mb-3">
            <input class="form-control" id="photo" type="file" name="icon_image" required />
            <label for="icNumber">Icon</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="at_name" />
            <label for="icNumber">Activity Type Name</label>

        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="at_desc"></textarea>
            <label for="address">Activity Type Description</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add">Add </button>
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