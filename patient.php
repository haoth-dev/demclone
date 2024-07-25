<?php
session_start();
$ipage = true;
$title = "Patient";

//process
require_once("function/function.php");

$patObj = new patient();
$patList = $patObj->list_all_patient_by_pcdID($_SESSION['pcd_id']);

$scObj = new caregiver();
$scList = $scObj->list_secondary_caregiver($_SESSION['pcd_id']);

if (isset($_POST['ajax_assign_btn'])) {
  $assignObj = new caregiver();
  $response = array();
  $_POST['pcd_id'] = $_SESSION['pcd_id'];
  $result = $assignObj->pcsc_status_update($_POST);
  $assignObj = new caregiver();
  $response['success'] = true;
  $response['data'] = $result;
  echo json_encode($response); //array response sent back to ajax.
  exit();
}

if (isset($_POST['ajax_delete_btn'])) {
  $delObj = new caregiver();
  $response = array();
  $result = $delObj->delete_scaregiver($_POST['scd_email']);
  if ($result) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }
  echo json_encode($response); //array response sent back to ajax.
  exit();
}

//header
require_once("sub/header.php");
?>

<div class="container">
  <br>
  <div class="form-floating row">
    <div class="col-2">
      <a href="nav_page.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
    </div>
  </div>
  <h4>People With Dementia</h4>

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">Info</button>
      <button class="nav-link" id="nav-ca-tab" data-bs-toggle="tab" data-bs-target="#nav-ca" type="button" role="tab" aria-controls="nav-ca" aria-selected="false">Caregiver </button>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
      <br>
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
              $careObj = new caregiver($_SESSION['pcd_id']);
              $pcd_name = $careObj->data['pcd_name'];
              $dt_name = htmlspecialchars($demObj->get_dem_type_name_only($value['dt_id']));
              $pt_stage = htmlspecialchars($value['pt_stage']);
              $pt_location = htmlspecialchars($value['pt_location']);
              $pt_qr_path = htmlspecialchars($value['pt_qr_path']);
              $pt_photo_path = htmlspecialchars($value['pt_photo_path']);
              $pt_id = htmlspecialchars($value['pt_id']);
            ?>
              <tr data-pcd-name="<?php echo htmlspecialchars($pcd_name); ?>" data-dt-name="<?php echo $dt_name; ?>" data-pt-stage="<?php echo $pt_stage; ?>" data-pt-location="<?php echo $pt_location; ?>" data-pt-qr-path="<?php echo $pt_qr_path; ?>" data-pt-photo-path="<?php echo $pt_photo_path; ?>" data-pt-id="<?php echo $pt_id; ?>" data-pt-name="<?php echo htmlspecialchars($value['pt_name']); ?>">
                <td><?php echo $counter; ?></td>
                <td><?php echo htmlspecialchars($value['pt_name']); ?></td>
                <td>
                  <a href="#" class="btn btn-outline-info profile-view-button" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-id-badge"></i>
                  </a>
                  <a href="#" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#profileModal2">
                    <i class="fas fa-qrcode"></i>
                  </a>
                  <a href="patient_edit.php?pt_id=<?php echo $pt_id; ?>" class="btn btn-outline-info">
                    <i class="fas fa-pen"></i>
                  </a>
                </td>
              </tr>
            <?php
              $counter++;
            }
            ?>
          </tbody>
        </table>
        <br>
      <?php } else { ?>
        <div class="alert alert-warning" role="alert">
          No person of Dementia Added yet
        </div>
      <?php } ?>
    </div>
    <div class="tab-pane fade" id="nav-ca" role="tabpanel" aria-labelledby="nav-ca-tab">
      <br>
      <?php if (!empty($patList)) {
        foreach ($patList as $value) { ?>
          <div class="card">
            <input type="hidden" class="pt_id_val" value="<?php echo $value['pt_id']; ?>">
            <h5 class="card-header"><?php echo $value['pt_name']; ?></h5>
            <div class="card-body">
              <table class="table">
                <thead>
                  <th>No</th>
                  <th>Name</th>
                  <th>Assign</th>
                  <th>Remove</th>
                </thead>
                <tbody>
                  <?php
                  $counter = 1;
                  if (!empty($scList)) {
                    $scObj2 = new caregiver();
                    foreach ($scList as $value2) { ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $value2['pcd_name']; ?></td>
                        <td>
                          <input type="hidden" class="pcsc_status_val" value="<?php echo $scObj2->pcsc_status_btn_check($value2['pcd_id'], $value['pt_id']); ?>">
                          <input type="hidden" class="pcd_id_val" value="<?php echo $value2['pcd_id']; ?>">
                          <button class="btn btn-outline-info" onclick="assign_sc(this)">
                            <i class="fa <?php echo $scObj2->pcsc_status_btn_toggle($value2['pcd_id'], $value['pt_id']); ?>" aria-hidden="true"></i>
                          </button>
                        </td>
                        <td>
                          <input type="hidden" class="pcd_email_val" value="<?php echo $value2['pcd_email']; ?>">
                          <button class="btn btn-outline-danger" onclick="delete_sc(this)">
                            <i class="fa fa-times" aria-hidden="true"></i>
                          </button>
                        </td>
                      </tr>
                    <?php
                      $counter++;
                    }
                  } else {
                    ?>
                    <div class="alert alert-warning" role="alert">
                      No Secondary caregiver Added yet...
                    </div>
                  <?php

                  } ?>
                </tbody>
              </table>
            </div>
          </div>
          <br>
        <?php }
      } else {
        ?>
        <div class="alert alert-warning" role="alert">
          No Secondary caregiver Added yet...
        </div>
      <?php
      } ?>
    </div>
  </div>

  <?php if ($_SESSION['pcd_level'] != 'secondary') { ?>
    <a href="patient_add.php" class="btn btn-primary floating-button">
      <i class="fas fa-plus"></i>
    </a>
  <?php } ?>

  <!--  FRONT CARD Modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Front Profile Card</h5>
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
                    <h3>Name</h3>
                    <p><span id="modal-pt-name"></span></p>
                  </div>
                  <div class="details-item">
                    <h3>Primary Caregiver</h3>
                    <p><span id="modal-pcd-name"></span></p>
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

  <!--  BACK CARD Modal -->
  <div class="modal fade" id="profileModal2" tabindex="-1" aria-labelledby="profileModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModal2Label">Back Profile Card</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Back Side Card -->
          <div class="card">
            <div class="card-body">
              <div class="back-card">
                <img src="asset/images/appicon_dark.png" alt="Company Logo" class="company-logo">
                <div class="company-name">dementiaBN</div>
                <div class="company-tagline">“To care for those who once cared for us is one of the highest honors.” ― Tia Walker</div>
                <div class="back-qr-code-column">
                  <h3>SCAN QR TO REPORT THIS PWD AS MISSING</h3>
                  <img id="modal-qr-code" src="" alt="QR Code" class="back-qr-code">
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
  // Function to initialize tab navigation
  function initializeTabNavigation() {
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
  }

  // Function to initialize profile modals
  function initializeProfileModals() {
    const profileViewButtons = document.querySelectorAll('.profile-view-button');

    profileViewButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        const row = event.currentTarget.closest('tr');
        document.getElementById('modal-profile-photo').src = row.dataset.ptPhotoPath;
        document.getElementById('modal-pt-name').textContent = row.dataset.ptName;
        document.getElementById('modal-pcd-name').textContent = row.dataset.pcdName;
        document.getElementById('modal-dementia-type').textContent = row.dataset.dtName;
        document.getElementById('modal-stage').textContent = row.dataset.ptStage;
        document.getElementById('modal-location').textContent = row.dataset.ptLocation;
      });
    });

    const qrCodeButtons = document.querySelectorAll('.btn-outline-info');

    qrCodeButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        const row = event.currentTarget.closest('tr');
        document.getElementById('modal-qr-code').src = row.dataset.ptQrPath;
      });
    });
  }

  // Main function to initialize all functionality
  function initialize() {
    initializeTabNavigation();
    initializeProfileModals();
  }

  // Wait for the DOM to be fully loaded before initializing
  document.addEventListener('DOMContentLoaded', initialize);
</script>
<script src="resource/js/patient.js"></script>
<?php
require_once("sub/footer.php");
?>