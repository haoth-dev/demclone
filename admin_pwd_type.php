<?php
session_start();
$ipage = true;
$title = "Dementia Type";

//process
require_once("function/function.php");
$demObj = new dementia();
$demTypeList = $demObj->list_all_dem_type();
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
                    Dementia Type
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            if (!empty($demTypeList)) {
                                foreach ($demTypeList as $value) {
                            ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $value['dt_name']; ?></td>
                                        <td>
                                            <a href="admin_caregiver_edit.php" class="btn btn-outline-info"><i class="fas fa-pen"></i></a>
                                            <a class="btn btn-outline-danger"><i class="fas fa-times"></i></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning" role="alert">
                                    No Dementia Type data added yet
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
?>