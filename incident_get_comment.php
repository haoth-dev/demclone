<?php
session_start();
$ipage = true;
$title = "Fetch Comments";

// Process
require_once("function/function.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['c_ref_id'])) {
        $c_ref_id = $_GET['c_ref_id'];
        $comObj = new comment();
        $comments = $comObj->list_inc_comment($c_ref_id, 'incident');

        if ($comments) {
            $response['success'] = true;
            $response['data'] = $comments;
        } else {
            $response['success'] = false;
            $response['data'] = 'No comments found';
        }
    } else {
        $response['success'] = false;
        $response['data'] = 'Invalid request';
    }
} else {
    $response['success'] = false;
    $response['data'] = 'Invalid request method';
}

echo json_encode($response);
exit();
