<?php
session_start();
$ipage = true;
$title = "login";

//process
require_once("function/function.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$caregiverObj = new caregiver();

$db_err = $caregiverObj->check_db_connect();
$response = array();

if ($db_err > 0) {
    $response['success'] = false;
    $response['message'] = 'db connection failed';
} else {
    $response['success'] = true;
    $response['message'] = 'db connection success';
}

echo json_encode($response);
exit();
