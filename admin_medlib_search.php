<?php
session_start();
$ipage = true;
$title = "Search Medication";

// Process
require_once("function/function.php");

$response = array();

if (isset($_POST['post_search_btn'])) {
    $meds_name = htmlspecialchars($_POST['meds_name'], ENT_QUOTES, 'UTF-8');
    if ($meds_name) {
        $medsObj = new medication();
        $search_result = $medsObj->admin_search_meds($meds_name);
        if (!empty($search_result)) {
            $response['success'] = true;
            $response['data'] = $search_result;
        } else {
            $response['success'] = false;
            $response['error'] = "No result found";
        }
    } else {
        $response['success'] = false;
        $response['error'] = "Invalid input";
    }
    echo json_encode($response);
    exit();
}

// Header
require_once("sub/header.php");
?>

<div class="container">
    <br>
    <div class="col-2">
        <a href="admin_medlib.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
    </div>
    <div class="card">
        <div class="card-header">
            Search Meds Panel
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <!-- Alert Container -->
                <div id="alert-container"></div>
                <!-- Loading Spinner -->
                <div id="loading-spinner" class="d-none">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="meds_search_input" placeholder="">
                    <label for="meds_search_input">Meds Name</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button" id="btn_search" onclick="admin_med_search()">Search</button>
                </div>
            </li>
            <li class="list-group-item">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Medication Name</th>
                        <th>Added by</th>
                        <th>Added on</th>
                        <th>Action</th>
                    </thead>

                    <tbody id="search_results">

                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>

<script>

</script>
<script src="resource/js/admin_medication.js"></script>
<?php
require_once("sub/footer.php");
?>