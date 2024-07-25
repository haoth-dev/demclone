<?php
session_start();
$ipage = true;
$title = "Admin Medication";

//process
require_once("function/function.php");
$medsObj = new medication();
$medsList = $medsObj->list_all_meds();
//header
require_once("sub/header.php");

//content
?>


<div class="container">

    <br>

    <div class="row">
        <div class="col-12 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    Medication List
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="admin_medlib_add.php" class="btn btn-primary">
                            <i class="fas fa-plus-square"></i> Add Medication
                        </a>
                    </h5>

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>#</th>
                            <th>Medication Name</th>
                            <th>Added by</th>
                            <th>Added on</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            if (!empty($medsList)) {
                                $counter = 1;
                                foreach ($medsList as $value) {
                                    $cgObj = new caregiver($value['pcd_id']);
                                    $meds_id = $value['meds_id'];
                                    $meds_name = $value['meds_name'];
                                    $meds_added_date = $value['meds_added_date'];
                                    $caregiver_name = $cgObj->data['pcd_name'];
                            ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $meds_name; ?></td>
                                        <td><?php echo $caregiver_name; ?></td>
                                        <td><?php echo $meds_added_date; ?></td>

                                        <td>
                                            <a href="admin_medlib_edit.php?meds_id=<?php echo urlencode($meds_id); ?>" class="btn btn-outline-info">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="admin_medlib_delete.php?meds_id=<?php echo urlencode($meds_id); ?>" class="btn btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning" role="alert">
                                    No Medication added yet
                                </div>
                            <?php
                            }

                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>



</div>

<?php

require_once("sub/footer.php");
?>s