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


    // Validate required fields

    // Perform any additional processing or database operations here
    // For example, insert the data into a database


    $missingObj = new missing();

    $result = $missingObj->insert_missing_pt($_POST);
    // $result = true;
    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Guest registration successful and missing person of dementia reported.';
        $response['data'] = $_POST;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Guest registration failed - please contact admin.';
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