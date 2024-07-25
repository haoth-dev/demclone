<?php
//config

//config
define('website_name', 'DementiaBN');
define("is_local", false); //tukar ke false kalau live server

define("kared_framework_version", '2.5.0');

//developer mode
define('dev_mode', true);

//ftp heera
define("host", "ftp://dementiabn.xyz");
define("ftp_ip", "ftp://153.92.11.225");
define("ftp_username", "u701929732");
define("ftp_password", "Hpcompaq1!");
define("port", "21");

//maintenance
$maintenance = false;

//db credentials
define("url", "localhost");
if (is_local) {
	$localIP = getHostByName(getHostName());
	define("domain_url", "http://$localIP/dementiabn/");

	//db info
	define("username", "root");
	define("password", "");
	define("name", "dementiabn");
} else {
	//url live host 1
	define("domain_url", "https://dementiabn.xyz/");

	//db info
	define("username", "u701929732_admin");
	define("password", "Hpcompaq1!");
	define("name", "u701929732_dementiabn");

	//map parameter
	define("google_map_api", "AIzaSyBXQRTPyp4IpEJ_fi_I2SlJfwKCizPWWC8");
	define("google_map_id", "a3c3e35b81b54559");
}



////////////////////////////////////////////////////////////////////////databases
//data

//maintenance codesA
if (!dev_mode) {
	$try = @mysqli_connect(url, username, password);
	if (!$try) $maintenance = true;
	if ($maintenance and $_SERVER['REQUEST_URI'] != '/kared_framework/maintenance.php') header('Location: maintenance.php');
}

////////////////////////////////////////////////////////////////////////email config
define("email_name", "DementiaBN");
define("email_username", "dementiabn@dementiabn.xyz");
define("email_password", "Hpcompaq1!");

//class
require_once("class/class.caregiver.php");
require_once("class/class.login.php");
require_once("class/class.patient.php");
require_once("class/class.medication.php");
require_once("class/class.dementia.php");
require_once("class/class.missing.php");
require_once("class/class.log.php");
require_once("class/class.incident.php");
require_once("class/class.inctype.php");
require_once("class/class.comment.php");
require_once("class/class.actype.php");
require_once("class/class.activity.php");


//timezone
ini_set('date.timezone', 'Asia/Brunei');


/////////////////////////////////////////////////////////////choose bootstrap version
define("bootstrap", '5.3');

//bootstrap version identifier
define("bootstrap3", '3.4.1');
define("bootstrap4", '4.3.1');
define("bootstrap5_0_2", '5.0.2');
define("bootstrap5_3_3", '5.3.3');


if (bootstrap == 3) define("bootstrapDir", bootstrap3);
else if (bootstrap == 4) define("bootstrapDir", bootstrap4);
else if (bootstrap == 5.0) define("bootstrapDir", bootstrap5_0_2);
else if (bootstrap == 5.3) define("bootstrapDir", bootstrap5_3_3);

//stylesheet
define("stylesheet", '
<link rel="stylesheet" href="resource/bootstrap/' . bootstrapDir . '/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="resource/css/snippet.css">
<link rel="stylesheet" href="resource/css/custom.css">

');

define("activity_css", '<link rel="stylesheet" href="resource/css/activity.css">');
define("profile_card_css", '<link rel="stylesheet" href="resource/css/profile_card.css">');
define("guest_css", '<link rel="stylesheet" href="resource/css/guest.css">');
define("pwd_profile_card_css", '<link rel="stylesheet" href="resource/css/pwd_profile_card.css">');
define("about_us", '<link rel="stylesheet" href="resource/css/aboutus.css">');

//javascript
define("top_js_script", '
<script src="resource/js/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script src="resource/bootstrap/' . bootstrapDir . '/js/bootstrap.min.js"></script>
<script src="resource/js/snippet.js"></script>
<script src="resource/js/mandatory.js"></script>
<script src="resource/js/custom_js.js"></script>





');
define("bottom_js_script", '
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="resource/js/admin_medication.js"></script>
<script src="resource/js/medication.js"></script>
<script src="resource/js/caregiver.js"></script>
<script src="resource/js/guest.js"></script>
<script src="resource/js/incident.js"></script>
<script src="resource/js/activity.js"></script>
');
