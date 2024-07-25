<?php
session_start();
$ipage = true;
$title = "Add Dementia Type";

//process
require_once("function/function.php");
if (isset($_POST['register'])) {
    $demObj = new dementia();
    $result = $demObj->insert_dem_type($_POST);
    if ($result) {
        alert("Dementia Type Add success");
    } else {
        alert("Dementia Type Add failed");
    }
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Add Dementia Type Form</h4>


    <form id="contactForm" method='post'>
        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="dt_name" />
            <label for="icNumber">Dementia Type Name</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="dt_desc"></textarea>
            <label for="address">Description</label>

        </div>

        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="register">Register</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="admin_pwd_type.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Dementia Type List</a>
            </div>
        </div>




    </form>




</div>


</div>

<?php

require_once("sub/footer.php");
?>