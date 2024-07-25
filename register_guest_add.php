<?php
session_start();
$ipage = true;
$title = "Guest Register";

//process
require_once("function/function.php");

$response = [];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $pt_id = $_POST['pt_id'] ?? null;
    $pcd_name = $_POST['mp_reporter_name'] ?? null;
    $pcd_contact = $_POST['mp_reporter_contact_no'] ?? null;
    $pcd_email = $_POST['mp_reporter_email'] ?? null;
    $mp_remark = $_POST['mp_remark'] ?? null;
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    // Validate required fields
    if ($pcd_name && $pcd_contact && $pcd_email) {
        // Perform any additional processing or database operations here
        // For example, insert the data into a database
        $missingObj = new missing();

        $result = $missingObj->insert_missing_pt($_POST);
        // $result = true;
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Guest registration successful and missing person of dementia reported.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Guest registration failed - please contact admin.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all required fields.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();

//header
require_once("sub/header.php");

//content
?>


<div class="container">



</div>

<?php

require_once("sub/footer.php");
?>