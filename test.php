<?php
session_start();
$ipage = true;
$title = "test"; //tukar ke test_2 kalau pakai bspl laptop

//process
require_once("function/function.php");

// Get the current year, month, week number, and day
$email = "alifjulaihi.mp@gmail.com";
$subject = "testign email";
$message = "this is test email form test page";
$result = ar_mail2($email,$subject,$message);
view_array($result);

//header
require_once("sub/header.php");

//content
?>




<?php
require_once("sub/footer.php");
?>