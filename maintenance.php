<?php
require_once('function/function.php');
if($maintenance) echo "
<body style='background-color:black;color:white;'>
<center>
<br>
<img src='asset/images/header_logo.png' width=150px><br>
<h2>
This website is currently undergoing maintenance
</h2>
</center>
</body>
";
else header("Location: logout.php");


?>
