<?php
session_start();
$ipage = true;
$title = "Support";

//process
require_once("function/function.php");
//view_array($_SESSION);
//view_array($_SESSION);
$scaregiverObj = new caregiver();
$scList = $scaregiverObj->list_secondary_caregiver($_SESSION['pcd_id']);



//header
require_once("sub/header.php");

//content
?>


<div class="container">

  <br>
  <div class="row">
    <div class="col-12 col-md-12 col-sm-12 ">
      <div class="form-floating row">
        <div class="col-2">
          <a href="nav_page.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          User List
        </div>

        <div class="card-body">
          <h5 class="card-title"></h5>
          <table class="table table-striped table-hover">
            <thead>
              <th>no</th>
              <th>Name</th>
              <th>Action</th>

            </thead>
            <tbody>
              <?php
              $counter = 1;
              if (!empty($scList)) {
                foreach ($scList as $value) {
                  $pcdObj = new caregiver($value['pcd_assign_id']); //primary caregiver Obj
                  $pcd_name = $pcdObj->data['pcd_name'];
                  $scd_name = $value['pcd_name'];
                  $scd_contact = $value['pcd_contact'];
                  $scd_address = $value['pcd_addr'];
                  $scd_email = $value['pcd_email'];
                  $level = $value['pcd_level'];
                  $photo_path = $value['pcd_photo_path'];
              ?>
                  <tr data-pcd-name="<?php echo $pcd_name; ?>" data-scd-name="<?php echo $scd_name; ?>" data-scd-address="<?php echo $scd_address; ?>" data-photo-path="<?php echo $photo_path; ?>" data-scd-contact="<?php echo $scd_contact; ?>" data-scd-email="<?php echo $scd_email; ?>" data-level="<?php echo $level; ?>">
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $value['pcd_name']; ?></td>
                    <td>
                      <a href="#" class="btn btn-outline-info profile-view-button" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <i class="fas fa-id-badge"></i>
                      </a>
                      <a href="scaregiver_edit.php?pcd_id=<?php echo urlencode($value['pcd_id']); ?>" class="btn btn-outline-info">
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
                    <p><span id="modal-scd-name"></span></p>

                  </div>
                  <div class="details-item">
                    <h3>Primary Caregiver</h3>
                    <p><span id="modal-primary-caregiver"></p>
                  </div>
                  <div class="details-item">
                    <h3>Contact Number</h3>
                    <p id="modal-contact-number"></p>
                  </div>
                  <div class="details-item">
                    <h3>Caregiver Level</h3>
                    <p><span id="modal-caregiver-level"></span></p>
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


  <?php
  if ($_SESSION['pcd_level'] != 'secondary') {
  ?>
    <a href="scaregiver_add.php" class="btn btn-primary floating-button">
      <i class="fas fa-plus"></i>
    </a>
  <?php
  }
  ?>

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
        document.getElementById('modal-scd-name').innerText = row.dataset.scdName;
        document.getElementById('modal-primary-caregiver').innerText = row.dataset.pcdName;
        document.getElementById('modal-contact-number').innerText = row.dataset.scdContact;
        document.getElementById('modal-caregiver-level').innerText = row.dataset.level;
        document.getElementById('modal-email').innerText = row.dataset.scdEmail;
        document.getElementById('modal-address').innerText = row.dataset.scdAddress;
      });
    });
  }




  // Wait for the DOM to be fully loaded before initializing
  document.addEventListener('DOMContentLoaded', initialize);
</script>
<?php

require_once("sub/footer.php");
?>
<!-- Font Awesome -->