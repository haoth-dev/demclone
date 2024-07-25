<?php
session_start();
$ipage = true;
$title = "meds Intake";

//process
require_once("function/function.php");

$pcd_id = $_SESSION['pcd_id'];
$patObj = new patient();
$medsObj = new medication();

//ready list of patient under current primary giver
$patList = $patObj->list_all_patient_by_pcdID($pcd_id);

//ready list of medication added under current primary giver 
$medsList = $medsObj->list_meds_by_pcd($pcd_id);
//view_array($medsList);

if (isset($_POST['assign_btn'])) {
    $response = array();
    $postMedsObj = new medication();
    $result = $postMedsObj->insert_assigned_meds($_POST);

    $response['success'] = true;
    $response['data'] = $_POST;
    echo json_encode($response); //array respon ane th yg d antar ke ajax balik.
    exit();
}

if (isset($_POST['delete_btn'])) {
    $response = array();
    $postDelMedObj = new medication();
    $result = $postDelMedObj->delete_assigned_meds($_POST);

    if ($result) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = $postDelMedObj->e_log;
    }


    $response['data'] = $_POST;
    echo json_encode($response); //array respon ane th yg d antar ke ajax balik.
    exit();
}
//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">Info</button>
            <button class="nav-link" id="nav-add-tab" data-bs-toggle="tab" data-bs-target="#nav-add" type="button" role="tab" aria-controls="nav-add" aria-selected="false">Assign Meds </button>

        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <!--Info Tab-->
        <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
            <br>
            <?php
            if (@$_GET['add_result']) {
                if (@$_GET['add_result'] == 'success') {
            ?>
                    <div class="alert alert-success" role="alert">
                        Assigned Medication Success
                    </div>
                <?php
                } else {
                }
            }

            if (@$_GET['edit_result']) {
                if (@$_GET['edit_result'] == 'success') {
                ?>
                    <div class="alert alert-success" role="alert">
                        Edit Assigned Medication Success
                    </div>
            <?php
                } else {
                }
            }
            ?>
            <?php
            if (!empty($patList)) {

                foreach ($patList as $value) {
                    $patData = new patient($value['pt_id']);
                    $assignedObj = new medication();
                    $medAssignList = $assignedObj->list_meds_assigned_to_patient($value['pt_id']);

            ?>
                    <div class="card ">
                        <h5 class="card-header "><?php echo $patData->data['pt_name'] ?></h5>
                        <div class="card-body">
                            <h5 class="card-title">Medication List</h5>
                            <?php
                            $counter = 1;
                            if (!empty($medAssignList)) {
                            ?>
                                <table class="table">

                                    <?php
                                    foreach ($medAssignList as $value) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $counter ?>. <?php echo $assignedObj->get_meds_name_only($value['meds_id']); ?> - <?php echo $value['pcm_qty'] ?> <?php echo $value['pcm_unit'] ?> - <?php echo $value['pcm_freq'] ?> times per day
                                            </td>
                                            <td>
                                                <a href="medication_assigned_edit.php?pcm_id=<?php echo $value['pcm_id'] ?>" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-danger delete-btn" data-pcm-id="<?php echo $value['pcm_id'] ?>" onclick="handleDeleteButtonClick(this)">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                        $counter++;
                                    }
                                    ?>





                                </table>
                            <?php

                            } else {
                            ?>
                                <div class="alert alert-warning" role="alert">
                                    No medication assigned yet to this Person of Dementia
                                </div>
                            <?php
                            }

                            ?>



                        </div>
                    </div>
                    <br>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    No Person of Dementia added yet, please add the Person of Dementia first.
                </div>
            <?php
            }
            ?>
        </div>

        <!--Assigned Meds Tab-->
        <div class="tab-pane fade" id="nav-add" role="tabpanel" aria-labelledby="nav-add-tab">
            <br>
            <div class="card">
                <div class="card-header">
                    Medication Intake
                </div>
                <div class="card-body">

                    <?php
                    if (!empty($patList)) {
                    ?>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="patientName" aria-label="patient_name">
                                <?php
                                foreach ($patList as $value) {
                                ?>
                                    <option value="<?php echo $value['pt_id'] ?>"><?php echo $value['pt_name']; ?></option>
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
                                    <option value="<?php echo $value['meds_id']; ?>"><?php echo $value['meds_name']; ?></option>
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

                    <div class="form-floating mb-3">
                        <input class="form-control" id="qtyPerServ" type="text" placeholder="qty per day" data-sb-validations="required" />
                        <label for="qtyPerServ">qty per serv</label>
                        <div class="invalid-feedback" data-sb-feedback="qtyPerServ:required">qty per day is required.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="medsUnit" aria-label="meds_unit">
                            <option value="g">gram</option>
                            <option value="mg">miligram</option>
                            <option value="L">litre</option>
                            <option value="ml">millilitre</option>
                            <option value="tablet">tablet</option>
                        </select>

                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="freqPerDay" type="text" placeholder="Freq per day" data-sb-validations="required" />
                        <label for="freqPerDay">Freq per day</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="sideEffect" type="text" placeholder="side effect" style="height: 10rem;" data-sb-validations="required"></textarea>
                        <label for="sideEffect">Meds Remark</label>
                        <div class="invalid-feedback" data-sb-feedback="sideEffect:required">side effect is required.</div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg <?php echo $medsObj->mi_btn_check(@$patList, @$medList); ?>" id="submitButton" type="submit" onclick="assign_meds()">Assign Meds</button>
                    </div>
                    <br>
                    <div class="d-grid">
                        <a class="btn btn-outline-secondary btn-lg" id="submitButton" href="nav_page.php">
                            < Back to Home</a>
                    </div>




                </div>
            </div>
        </div>
    </div>


</div>
<script src="resource/js/medication.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('.nav-link');
        const tabContent = document.querySelectorAll('.tab-pane');

        function setActiveTab(tabId) {
            navLinks.forEach(link => {
                const isSelected = (link.id === tabId);
                link.classList.toggle('active', isSelected);
                link.setAttribute('aria-selected', isSelected);
                const targetId = link.getAttribute('data-bs-target');
                const target = document.querySelector(targetId);
                if (target) {
                    target.classList.toggle('show', isSelected);
                    target.classList.toggle('active', isSelected);
                }
            });
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.id);
                setActiveTab(this.id);
            });
        });

        const activeTabId = localStorage.getItem('activeTab');
        if (activeTabId) {
            setActiveTab(activeTabId);
        } else {
            setActiveTab('nav-info-tab'); // Default to first tab if none is stored
        }
    });
</script>
<?php

require_once("sub/footer.php");
?>