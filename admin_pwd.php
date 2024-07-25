<?php
session_start();
$ipage = true;
$title = "Admin PWD";

// Include functions
require_once("function/function.php");

$patObj = new patient();
$patList = $patObj->list_all_patient();

$scObj = new caregiver();
$scList = $scObj->list_secondary_caregiver($_SESSION['pcd_id']);

// Handle AJAX assign button
if (isset($_POST['ajax_assign_btn'])) {
    $assignObj = new caregiver();
    $_POST['pcd_id'] = $_SESSION['pcd_id'];
    $result = $assignObj->pcsc_status_update($_POST);

    $response = [
        'success' => true,
        'data' => $result
    ];
    echo json_encode($response);
    exit();
}

// Handle AJAX delete button
if (isset($_POST['ajax_delete_btn'])) {
    $delObj = new caregiver();
    $result = $delObj->delete_scaregiver($_POST['scd_email']);

    $response = [
        'success' => $result
    ];
    echo json_encode($response);
    exit();
}

// Include header
require_once("sub/header.php");
?>

<div class="container">
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    PWD List
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="admin_pwd_add.php" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Add PWD
                        </a>
                    </h5>
                    <?php if (!empty($patList)) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($patList as $value) {
                                    $demObj = new dementia($value['dt_id']);
                                    $careObj = new caregiver($value['pcd_id']);
                                    $pcd_name = htmlspecialchars($careObj->data['pcd_name']);
                                    $pcd_contact = htmlspecialchars($careObj->data['pcd_contact']);
                                    $dt_name = htmlspecialchars($demObj->get_dem_type_name_only($value['dt_id']));
                                    $pt_stage = htmlspecialchars($value['pt_stage']);
                                    $pt_location = htmlspecialchars($value['pt_location']);
                                    $pt_qr_path = htmlspecialchars($value['pt_qr_path']);
                                    $pt_photo_path = htmlspecialchars($value['pt_photo_path']);
                                    $pt_id = htmlspecialchars($value['pt_id']);
                                ?>
                                    <tr data-pcd-contact="<?php echo $pcd_contact; ?>" data-pcd-name="<?php echo $pcd_name; ?>" data-dt-name="<?php echo $dt_name; ?>" data-pt-stage="<?php echo $pt_stage; ?>" data-pt-location="<?php echo $pt_location; ?>" data-pt-qr-path="<?php echo $pt_qr_path; ?>" data-pt-photo-path="<?php echo $pt_photo_path; ?>" data-pt-id="<?php echo $pt_id; ?>" data-pt-name="<?php echo htmlspecialchars($value['pt_name']); ?>">
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo htmlspecialchars($value['pt_name']); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-outline-info profile-view-button" data-bs-toggle="modal" data-bs-target="#profileModal">
                                                <i class="fas fa-id-badge"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-info qr-code-view-button" data-bs-toggle="modal" data-bs-target="#profileModal2">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <a href="admin_pwd_edit.php?pt_id=<?php echo $pt_id; ?>" class="btn btn-outline-info">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php $counter++;
                                } ?>
                            </tbody>
                        </table>
                        <br>
                    <?php } else { ?>
                        <div class="alert alert-warning" role="alert">
                            No person of Dementia Added yet
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Front Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Front Profile Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-card">
                                <div class="photo-column">
                                    <img id="modal-profile-photo" src="" alt="Profile Photo" class="profile-photo">
                                </div>
                                <div class="details-column">
                                    <div class="details-item">
                                        <h3>Name</h3>
                                        <p><span id="modal-pt-name"></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Primary Caregiver Name</h3>
                                        <p><span id="modal-pcd-name"></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Contact Number</h3>
                                        <p><span id="modal-pcd-contact"></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Dementia Type</h3>
                                        <p><span id="modal-dementia-type"></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Stage</h3>
                                        <p><span id="modal-stage"></span></p>
                                    </div>
                                    <div class="details-item">
                                        <h3>Location</h3>
                                        <p><span id="modal-location"></span></p>
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

    <!-- Back Profile Modal -->
    <div class="modal fade" id="profileModal2" tabindex="-1" aria-labelledby="profileModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModal2Label">Back Profile Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="back-card">
                                <img src="asset/images/appicon_dark.png" alt="Company Logo" class="company-logo">
                                <div class="company-name">dementiaBN</div>
                                <div class="company-tagline">“To care for those who once cared for us is one of the highest honors.” ― Tia Walker</div>
                                <div class="back-qr-code-column">
                                    <h3>SCAN QR TO REPORT THIS PWD AS MISSING</h3>
                                    <img id="modal-qr-code-2" src="" alt="QR Code" class="back-qr-code">
                                </div>
                                <div class="company-website">www.dementiabn.xyz</div>
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
</div>

<script>
    // Function to initialize profile modals
    function initializeProfileModals() {
        document.querySelectorAll('.profile-view-button').forEach(button => {
            button.addEventListener('click', (event) => {
                const row = event.currentTarget.closest('tr');
                document.getElementById('modal-profile-photo').src = row.dataset.ptPhotoPath;
                document.getElementById('modal-pt-name').textContent = row.dataset.ptName;
                document.getElementById('modal-pcd-name').textContent = row.dataset.pcdName;
                document.getElementById('modal-pcd-contact').textContent = row.dataset.pcdContact;
                document.getElementById('modal-dementia-type').textContent = row.dataset.dtName;
                document.getElementById('modal-stage').textContent = row.dataset.ptStage;
                document.getElementById('modal-location').textContent = row.dataset.ptLocation;
            });
        });

        document.querySelectorAll('.qr-code-view-button').forEach(button => {
            button.addEventListener('click', (event) => {
                const row = event.currentTarget.closest('tr');
                document.getElementById('modal-qr-code-2').src = row.dataset.ptQrPath;
            });
        });
    }

    // Main function to initialize all functionality
    function initialize() {
        initializeProfileModals();
    }

    // Wait for the DOM to be fully loaded before initializing
    document.addEventListener('DOMContentLoaded', initialize);
</script>

<?php
require_once("sub/footer.php");
?>