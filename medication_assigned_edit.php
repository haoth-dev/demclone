<?php
session_start();
$ipage = true;
$title = "MI Edit";

//process
require_once("function/function.php");
//view_array($_SESSION);

$pcd_id = $_SESSION['pcd_id'];
$patObj = new patient();
$medsObj = new medication();

//ready list of patient under current primary giver
$patList = $patObj->list_all_patient_by_pcdID($pcd_id);

//ready list of medication added under current primary giver 
$medsList = $medsObj->list_meds_by_pcd($pcd_id);
//view_array($medsList);

if (isset($_GET['pcm_id'])) {
    $pcmData = new medication(null, $_GET['pcm_id']);
    // view_array($pcmData->data);
}

if (isset($_POST['edit_btn'])) {
    $response = array();
    $postMedsObj = new medication();
    $result = $postMedsObj->edit_assigned_meds($_POST);

    if ($result) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = $postMedsObj->e_log;
    }
    echo json_encode($response); //array respon ane th yg d antar ke ajax balik.
    exit();
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>

    <div class="card ">
        <div class="card-header">
            Medication Intake
        </div>
        <div class="card-body">

            <?php
            if (!empty($patList)) {
            ?>
                <div class="form-floating mb-3">
                    <select class="form-select" id="patientName" aria-label="patient_name" disabled>
                        <?php
                        foreach ($patList as $value) {
                        ?>
                            <option value="<?php echo $value['pt_id']; ?>" <?php echo selection_equal($pcmData->data['pt_id'], $value['pt_id']);  ?>><?php echo $value['pt_name']; ?></option>
                        <?php

                        }
                        ?>

                    </select>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-warning" role="alert">
                    No Person of Dementia added yet, please add the Person of Dementia first.
                </div>
            <?php
            }
            ?>


            <?php
            if (!empty($medsList)) {
            ?>
                <div class="form-floating mb-3">
                    <select class="form-select" id="medsName" aria-label="meds_name">
                        <?php
                        foreach ($medsList as $value) {
                        ?>
                            <option value="<?php echo $value['meds_id']; ?>" <?php echo selection_equal($pcmData->data['meds_id'], $value['meds_id']);  ?>><?php echo $value['meds_name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-warning" role="alert">
                    No Meds added yet, please add the Meds first.
                </div>
            <?php
            }
            ?>
            <input type=hidden id=pcd_id value=<?php echo $_SESSION['pcd_id'] ?>>
            <input type=hidden id=pcm_id value=<?php echo $_GET['pcm_id'] ?>>


            <div class="form-floating mb-3">
                <input class="form-control" id="qtyPerServ" type="text" placeholder="qty per day" data-sb-validations="required" value="<?php echo $pcmData->data['pcm_qty'];  ?>">
                <label for="qtyPerServ">qty per serv</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="medsUnit" aria-label="meds_unit">
                    <option value="g" <?php echo selection_equal($pcmData->data['pcm_unit'], 'g'); ?>>gram</option>
                    <option value="mg" <?php echo selection_equal($pcmData->data['pcm_unit'], 'mg'); ?>>miligram</option>
                    <option value="L" <?php echo selection_equal($pcmData->data['pcm_unit'], 'L'); ?>>litre</option>
                    <option value="ml" <?php echo selection_equal($pcmData->data['pcm_unit'], 'ml'); ?>>millilitre</option>
                    <option value="tablet" <?php echo selection_equal($pcmData->data['pcm_unit'], 'tablet'); ?>>tablet</option>
                </select>

            </div>

            <div class="form-floating mb-3">
                <input class="form-control" id="freqPerDay" type="text" placeholder="Freq per day" data-sb-validations="required" value="<?php echo $pcmData->data['pcm_freq']; ?>">
                <label for="freqPerDay">Freq per day</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="sideEffect" type="text" placeholder="side effect" style="height: 10rem;" data-sb-validations="required"><?php echo $pcmData->data['pcm_remark']; ?></textarea>
                <label for="sideEffect">Meds Remark</label>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary btn-lg" id="submitButton" type="submit" onclick="assign_meds_edit()">Edit</button>
            </div>
            <br>
            <div class="d-grid">
                <a class="btn btn-outline-secondary btn-lg" id="submitButton" href="medication_intake.php">
                    < Back to Medication Intake Page</a>
            </div>




        </div>
    </div>



</div>



</div>
<script src="resource/js/medication.js"></script>
<?php

require_once("sub/footer.php");
?>