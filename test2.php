<?php
session_start();
$ipage = true;
$title = "Admin Log TEST";

//process
require_once("function/function.php");
$logObj = new log();
$allLog = $logObj->list_all_admin_log();
$accessLog = $logObj->list_access_log();
$adminActLog = $logObj->list_web_act_log();

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <div class="card">
        <h5 class="card-header">Admin Log</h5>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Much longer nav link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">...</div>
                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...</div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="log_all" role="tabpanel" aria-labelledby="log-all-tab">
                    <?php
                    if (!empty($allLog)) {
                    ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>no</th>
                                <th>log type</th>
                                <th>user</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($allLog as $value) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['al_type']; ?></td>
                                        <td><?php echo $value['pcd_id']; ?></td>
                                        <td><?php echo $value['al_detail']; ?></td>
                                        <td><?php echo $value['al_date']; ?></td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-warning" role="alert">
                            no log saved yet...
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="tab-pane" id="log_access" role="tabpanel" aria-labelledby="log-access-tab">
                    <?php
                    if (!empty($accessLog)) {
                    ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>no</th>
                                <th>user</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($accessLog as $value) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['pcd_id']; ?></td>
                                        <td><?php echo $value['al_detail']; ?></td>
                                        <td><?php echo $value['al_date']; ?></td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-warning" role="alert">
                            no log saved yet...
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="tab-pane" id="log_act" role="tabpanel" aria-labelledby="log-activity-tab">

                    <?php
                    if (!empty($adminActLog)) {
                    ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>no</th>
                                <th>user</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($adminActLog as $value) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['pcd_id']; ?></td>
                                        <td><?php echo $value['al_detail']; ?></td>
                                        <td><?php echo $value['al_date']; ?></td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-warning" role="alert">
                            no log saved yet...
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>



</div>
<script>
    var triggerFirstTabEl = document.querySelector('#myTab li:first-child button')
    bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab
</script>

<?php


require_once("sub/footer.php");
?>