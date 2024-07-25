<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");

//header
require_once("sub/header.php");

//content
?>


<div class="container">
  <div class="alert alert-primary" role="alert">
    mainframe checkpoint - <?php echo getHostName(); ?> - <?php echo servDate(); ?>
  </div>


</div>

<?php

require_once("sub/footer.php");
?>
