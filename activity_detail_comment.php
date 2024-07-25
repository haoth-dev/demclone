<?php
session_start();
$ipage = true;
$title = "ACTIVITY ADD Comment";

// Process
require_once("function/function.php");

// Check if the specific AJAX request is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['CONTENT_TYPE'] == 'application/json') {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $response = array();

    if (isset($data['post_comment'])) {
        // Extract the variables from the JSON data
        $c_content = $data['c_content'];
        $c_ref_id = $data['c_ref_id'];
        $c_task_type = $data['c_task_type'];
        $c_commentor_id = $data['c_commentor_id'];
        $comObj = new comment();

        // Add the new ACTIVITY comment
        $addCommentResult = $comObj->post_act_comment($c_content, $c_ref_id);

        if ($addCommentResult) {
            // Fetch all comments related to the activity
            $comments = $comObj->list_act_comment($c_ref_id, $c_task_type);

            // Send a success response
            $response['success'] = true;
            $response['data'] = $comments;
        } else {
            // Send an error response if the addition fails
            $err = $comObj->e_log;
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
