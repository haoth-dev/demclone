<?php
session_start();
$ipage = true;
$title = "Admin Dashboard";

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
        <h4>Hi <?php echo $_SESSION['pcd_name']; ?>, <b>[<?php echo $_SESSION['pcd_level'] ?>]</b></h4>
    </div>
    <br>
    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image ">
                    <a href="admin_user_mgmt.php"><img src="asset\images\user.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">User Management</h5>
                    </center>

                </div>
            </div>
        </div>



        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image ">
                    <a href="admin_pwd.php"><img src="asset\images\patient.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">People with Dementia</h5>
                    </center>

                </div>
            </div>
        </div>



        <?php

        ?>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="admin_activity.php"><img src="asset\images\activity.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Activity</h5>
                    </center>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="admin_medlib.php"><img src="asset\images\medical-report.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Medication Library</h5>
                    </center>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="admin_incident.php"><img src="asset\images\incident.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Incident</h5>
                    </center>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="missing_pwd.php"><img src="asset\images\missing.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Report Missing Person</h5>
                    </center>

                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="#"><img src="asset\images\chart.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Report Gen</h5>
                    </center>

                </div>
            </div>
        </div>


        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="#"><img src="asset\images\book.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Solution</h5>
                    </center>

                </div>
            </div>
        </div>



        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body center-image">
                    <a href="admin_log.php"><img src="asset\images\log.png" class="rounded " alt="Responsive image" height="100" width="100"></a>
                </div>
                <div class="card-footer">
                    <center>
                        <h5 class="card-title">Log</h5>
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