<?php
session_start();
$ipage = true;
$title = "QR Index";

//process
require_once("function/function.php");
if (isset($_GET['pt_id'])) {
    $patObj = new patient($_GET['pt_id']);
    $careObj = new caregiver($patObj->data['pcd_id']);
    //view_array($patObj->data);

    if (isset($_SESSION['pcd_id'])) {
        $page = "add_missing_pwd_for_pcd.php";
    } else {
        $page = "register_guest.php";
    }
}

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <h2>Welcome to Dementiabn</h2>
    <br>
    <div class="card">
        <div class="card-header">
            <h3>Report this missing Person with Dementia:</h3>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2 mb-3">
                <a class="btn btn-primary btn-block" type="button" href="<?php echo $page; ?>?pt_id=<?php echo $_GET['pt_id'];  ?>">Alert caregiver via App</a>
            </div>

            <hr>
            <h4>
                <center>OR</center>
            </h4>
            <hr>
            <input type="hidden" id="pt_id" value="<?php echo $_GET['pt_id'] ?>">
            <input type="hidden" id="pt_name" value="<?php echo $patObj->data['pt_name'] ?>">
            <input type="hidden" id="pt_photo_path" value=<?php echo $patObj->data['pt_photo_path'] ?>>
            <input type="hidden" id="pcd_name" value=<?php echo $careObj->data['pcd_name'] ?>>
            <input type="hidden" id="pcd_contact" value=<?php echo $careObj->data['pcd_contact'] ?>>

            <div class="d-grid gap-2">
                <button class="btn btn-info btn-block" type="button" onclick="show_report_modal()">Contact caregiver for this Person of Dementia</button>
            </div>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>


</div>
<script>
    function show_report_modal() {
        // Get the hidden input values
        const ptId = document.getElementById('pt_id').value;
        const ptName = document.getElementById('pt_name').value;
        const ptPhotoPath = document.getElementById('pt_photo_path').value;
        const pcdName = document.getElementById('pcd_name').value;
        const pcdContact = document.getElementById('pcd_contact').value;

        // Create a modal to display the hidden input values
        const modalContent = `
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Caregiver Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="${ptPhotoPath}" class="img-fluid mb-3" alt="Patient Photo">
                        <p><strong>Patient ID:</strong> ${ptId}</p>
                        <p><strong>Patient Name:</strong> ${ptName}</p>
                        <p><strong>Caregiver Name:</strong> ${pcdName}</p>
                        <p><strong>Caregiver Contact:</strong> ${pcdContact}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;

        // Append the modal to the body and show it
        document.body.insertAdjacentHTML('beforeend', modalContent);
        const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
        reportModal.show();

        // Remove the modal from the DOM after it's closed
        document.getElementById('reportModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('reportModal').remove();
        });
    }
</script>



<?php

require_once("sub/footer.php");
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>