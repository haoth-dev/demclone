<?php
session_start();
$ipage = true;
$title = "QR CODE";

//process
require_once("function/function.php");

include('module/phpqrcode/qrlib.php');
//include('config.php');

// how to save PNG codes to server

$tempDir = "asset/qr/";

$codeContents = 'http://localhost/dementiabn/missing_pt.php?pt_id=5';

// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileName = '005_file_' . md5($codeContents) . '.png';
$fileName = str_replace("'", "", $fileName);

$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $tempDir . $fileName;

// generating
if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
    echo 'File generated!';
    echo '<hr />';
} else {
    echo 'File already generated! We can use this cached file to speed up site on common codes!';
    echo '<hr />';
}

echo 'Server PNG File: ' . $pngAbsoluteFilePath;
echo '<hr />';

// displaying
echo '<img src="' . $urlRelativeFilePath . '" />';

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <h1>QR GENERATOR</h1>


</div>

<?php

require_once("sub/footer.php");
?>