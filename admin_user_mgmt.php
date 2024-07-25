<?php
session_start();
$ipage = true;
$title = "Admin User Mgmt";

//process
require_once("function/function.php");

$cgObj = new caregiver();
$caregiverList = $cgObj->get_all_caregiver_data();
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
                    User List
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="admin_user_add.php" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Add Caregiver
                        </a>
                    </h5>

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>no</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Level</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            if (!empty($caregiverList)) {
                                foreach ($caregiverList as $value) {
                                    $caregiver_name = $value['pcd_name'];
                                    $caregiver_contact = $value['pcd_contact'];
                                    $caregiver_address = $value['pcd_addr'];
                                    $caregiver_email = $value['pcd_email'];
                                    $level = $value['pcd_level'];
                                    $photo_path = $value['pcd_photo_path'];
                            ?>
                                    <tr data-caregiver-name="<?php echo $caregiver_name; ?>" data-caregiver-address="<?php echo $caregiver_address; ?>" data-photo-path="<?php echo $photo_path; ?>" data-caregiver-contact="<?php echo $caregiver_contact; ?>" data-caregiver-email="<?php echo $caregiver_email; ?>" data-level="<?php echo $level; ?>">
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $caregiver_name; ?></td>
                                        <td><?php echo $caregiver_email; ?></td>
                                        <td><?php echo $caregiver_contact; ?></td>
                                        <td><?php echo $level; ?></td>


                                        <td>
                                            <a href="#" class="btn btn-outline-info profile-view-button" data-bs-toggle="modal" data-bs-target="#profileModal">
                                                <i class="fas fa-id-badge"></i>
                                            </a>
                                            <a href="admin_user_edit.php?pcd_id=<?php echo urlencode($value['pcd_id']); ?>" class="btn btn-outline-info">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning" role="alert">
                                    No user added yet
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

<!-- Modal Structure -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Caregiver Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Front Side Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="profile-card">
                            <div class="photo-column">
                                <img id="modal-profile-photo" src="" alt="Profile Photo" class="profile-photo">
                            </div>
                            <div class="details-column">
                                <div class="details-item">
                                    <h3>Caregiver Name</h3>
                                    <p><span id="modal-caregiver-name"></span></p>

                                </div>

                                <div class="details-item">
                                    <h3>Email</h3>
                                    <p><span id="modal-caregiver-email"></p>
                                </div>
                                <div class="details-item">
                                    <h3>Contact Number</h3>
                                    <p id="modal-contact-number"></p>
                                </div>
                                <div class="details-item">
                                    <h3>Caregiver Level</h3>
                                    <p><span id="modal-caregiver-level"></span></p>
                                </div>

                                <div class="details-item">
                                    <h3>Address</h3>
                                    <p><span id="modal-caregiver-address"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Main function to initialize all functionality
    function initialize() {
        initializeProfileModals();
    }
    // Function to initialize profile modals
    function initializeProfileModals() {
        const profileViewButtons = document.querySelectorAll('.profile-view-button');

        profileViewButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const row = event.currentTarget.closest('tr');
                document.getElementById('modal-profile-photo').src = row.dataset.photoPath;
                document.getElementById('modal-caregiver-name').innerText = row.dataset.caregiverName;
                document.getElementById('modal-contact-number').innerText = row.dataset.caregiverContact;
                document.getElementById('modal-caregiver-level').innerText = row.dataset.level;
                document.getElementById('modal-caregiver-email').innerText = row.dataset.caregiverEmail;
                document.getElementById('modal-caregiver-address').innerText = row.dataset.caregiverAddress;
            });
        });
    }




    // Wait for the DOM to be fully loaded before initializing
    document.addEventListener('DOMContentLoaded', initialize);
</script>
<?php

require_once("sub/footer.php");
?>