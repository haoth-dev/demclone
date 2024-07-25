<?php
session_start();
$ipage = true;
$title = "Admin Activity Type";

//process
require_once("function/function.php");

$atObj = new actype();
$atList = $atObj->list_all_actype();
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
                    Activity Type List
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="admin_actype_add.php" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Add Activity Type
                        </a>
                    </h5>

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            if (!empty($atList)) {
                                foreach ($atList as $value) {
                                    $at_name = $value['at_name'];
                                    $at_desc = $value['at_desc'];
                                    $at_icon_path = $value['at_icon_path'];
                            ?>
                                    <tr data-at-name="<?php echo $at_name; ?>" data-at-desc="<?php echo $at_desc; ?>" data-at-icon-path="<?php echo $at_icon_path; ?>">
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $at_name; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-outline-info profile-view-button" data-bs-toggle="modal" data-bs-target="#iconModal">
                                                <i class="fas fa-icons"></i>
                                            </a>
                                            <a href="admin_actype_edit.php?at_id=<?php echo $value['at_id']; ?>" class="btn btn-outline-info">
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
<div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconModalLabel">Activity Type Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Front Side Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="profile-card">
                            <div class="photo-column">
                                <img id="modal-icon-photo" src="" alt="icon Photo" class="profile-photo">
                            </div>
                            <div class="details-column">
                                <div class="details-item">
                                    <h3>Activity Type Name</h3>
                                    <p><span id="modal-actype-name"></span></p>
                                </div>
                                <div class="details-item">
                                    <h3>Description</h3>
                                    <p><span id="modal-actype-desc"></span></p>
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
                document.getElementById('modal-icon-photo').src = row.dataset.atIconPath;
                document.getElementById('modal-actype-name').innerText = row.dataset.atName;
                document.getElementById('modal-actype-desc').innerText = row.dataset.atDesc;
            });
        });
    }

    // Wait for the DOM to be fully loaded before initializing
    document.addEventListener('DOMContentLoaded', initialize);
</script>

<?php
require_once("sub/footer.php");
?>