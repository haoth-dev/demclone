<?php
session_start();
$ipage = true;
$title = "Medication";

// Process
require_once("function/function.php");

// Check if the specific AJAX request is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['CONTENT_TYPE'] == 'application/json') {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);


    $response = array();

    // Check if the specific AJAX request is set
    if (isset($data['update_account'])) {
        // Extract the variables from the JSON data
        $l_username = $data['l_username'];
        $current_pass = $data['current_pass'];
        $new_pass = $data['new_pass'];
        $c_new_pass = $data['c_new_pass'];
        $loginObj = new login($l_username);
        // Perform your validation and update logic here

        // Perform the update operation (e.g., update password in the database)
        // Assuming you have a function called updatePassword
        $updateResult =  $loginObj->update_password($l_username, $current_pass, $new_pass, $c_new_pass);

        if ($updateResult) {
            // Send a success response
            $response['success'] = true;
            $response['data'] = 'Password updated successfully.';
        } else {
            // Send an error response if update fails
            $err = $loginObj->e_log;
            $response['success'] = false;
            $response['data'] = $err;
        }

        // Send the response back to the AJAX request
        echo json_encode($response);
        exit();
    } else {
        // Send an error response if the required POST data is not set
        echo json_encode(['success' => false, 'data' => 'Invalid request']);
        exit();
    }
} else {
    // Send an error response for invalid request method
    echo json_encode(['success' => false, 'data' => 'Invalid request method']);
    exit();
}



// Header
require_once("sub/header.php");

// Footer
require_once("sub/footer.php");
