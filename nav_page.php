<?php
session_start();
$ipage = true;
$title = "navigation";

//process
require_once("function/function.php");
//view_array($_SESSION);

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <div class="alert alert-success" role="alert">
        <h4>Hi <?php echo $_SESSION['pcd_name']; ?>, <b>[<?php echo $_SESSION['pcd_level'] ?> Caregiver]</b> </h4>
    </div>
    <br>

    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="activity.php"><img src="asset\images\document.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Activity Log</h5>
                    </center>

                </div>
            </div>
        </div>

        <?php

        if ($_SESSION['pcd_level'] == 'primary') $patientPage = 'patient.php';
        if ($_SESSION['pcd_level'] == 'secondary') $patientPage = 'patient2.php';
        ?>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image ">
                    <a href="<?php echo $patientPage; ?>"><img src="asset\images\patient.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">People with Dementia</h5>
                    </center>

                </div>
            </div>
        </div>



        <?php
        if ($_SESSION['pcd_level'] != 'secondary') {
        ?>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body center-image ">
                        <a href="support.php"><img src="asset\images\support.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                    </div>
                    <div class="card-footer">
                        <center>
                            <h5 class="card-title">Additional Support</h5>
                        </center>

                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body center-image">
                        <a href="medication.php"><img src="asset\images\medical-report.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                    </div>
                    <div class="card-footer">
                        <center>
                            <h5 class="card-title">Medication</h5>
                        </center>

                    </div>
                </div>
            </div>


        <?php
        }
        ?>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="medication_intake.php"><img src="asset\images\health.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Medication Intake</h5>
                    </center>

                </div>
            </div>
        </div>


        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="user_missing_pwd.php"><img src="asset\images\missing.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title"> Missing Person Incident</h5>
                    </center>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="incident.php"><img src="asset\images\incident.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title"> My Incident</h5>
                    </center>

                </div>
            </div>
        </div>


        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image ">
                    <a href="profile.php"><img src="asset\images\user.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">My Profile</h5>
                    </center>

                </div>
            </div>
        </div>


    </div>
</div>


</div>
<?php

require_once("sub/footer.php");
?>