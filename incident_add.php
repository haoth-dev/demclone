<?php
session_start();
$ipage = true;
$title = "Add Incident";

//process
require_once("function/function.php");

$itObj = new inctype();
$itList = $itObj->list_all_inc_type();


if (isset($_POST['add'])) {
    $incObj = new incident();
    $_POST['inc_caller'] = $_SESSION['pcd_email'];
    $_POST['inc_status'] = 'In-Progress';
    $clean_post = $incObj->sanitize_post_data($_POST);
    $result = $incObj->insert_incident($clean_post);
    if (!empty($result)) {
        $success = true;
    } else {
        $err = $incObj->e_log;
        $success = false;
    }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h4>Add New Incident</h4>
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Note!</h4>
        <p>For Missing PWD type incident. Please add date and time last seen person with dementia at incident remark as this info is essential for filing police report. </p>
        <hr>

    </div>
    <?php
    if (!empty($_POST)) {
        success_alert(@$success, "Successfully Add New Incident", @$err);
    }
    ?>


    <form id="contactForm" method='post'>


        <?php
        if (!empty($itList)) {
        ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Type</label>
                <select class="form-select" id="inputGroupSelect01" name="it_id">
                    <?php
                    foreach ($itList as $value) {
                    ?>
                        <option value="<?php echo $value['it_id'] ?>"><?php echo $value['it_name']; ?></option>
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
            <input class="form-control" id="icNumber" type="text" placeholder="Meds Name" data-sb-validations="required" name="inc_title" />
            <label for="icNumber">Incident Title</label>
            <div class="invalid-feedback" data-sb-feedback="icNumber:required">IC Number is required.</div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="address" type="text" placeholder="Meds Remark" style="height: 10rem;" data-sb-validations="required" name="inc_desc"></textarea>
            <label for="address">Incident Remark</label>
            <div class="invalid-feedback" data-sb-feedback="address:required">Address is required.</div>
        </div>




        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add">Add Incident</button>
            </div>
        </div>

        <div class="form-floating row">
            <div class="col-12 ">
                <a href="incident.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Back to Incident Page</a>
            </div>
        </div>




    </form>




</div>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->