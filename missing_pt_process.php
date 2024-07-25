<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Log all received POST data
    error_log("Received POST data: " . print_r($_POST, true));

    // Retrieve and sanitize form data
    $latitude = isset($_POST['latitude']) ? htmlspecialchars($_POST['latitude']) : 'Not set';
    $longitude = isset($_POST['longitude']) ? htmlspecialchars($_POST['longitude']) : 'Not set';
    $mp_reporter = isset($_POST['mp_reporter']) ? htmlspecialchars($_POST['mp_reporter']) : 'Not set';
    $mp_contact = isset($_POST['mp_contact']) ? htmlspecialchars($_POST['mp_contact']) : 'Not set';
    $pcd_id = isset($_POST['pcd_id']) ? htmlspecialchars($_POST['pcd_id']) : 'Not set';
    $pt_id = isset($_POST['pt_id']) ? htmlspecialchars($_POST['pt_id']) : 'Not set';

    // Display the received data
    echo "Latitude: " . $latitude . "<br>";
    echo "Longitude: " . $longitude . "<br>";
    echo "Reporter: " . $mp_reporter . "<br>";
    echo "Contact: " . $mp_contact . "<br>";
    echo "PCD ID: " . $pcd_id . "<br>";
    echo "PT ID: " . $pt_id . "<br>";
} else {
    echo "No data received.";
    error_log("No data received.");
}
//header
require_once("sub/header.php");

//content
?>


<div class="container">



</div>

<?php

require_once("sub/footer.php");
?>