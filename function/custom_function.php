<?php
function navbar_active($page)
{
	global $link;
	if ($link == $page) {
		return "active";
	}
}

function age_converter($dob)
{
	$dob = $dob;
	$year = (date('Y') - date('Y', strtotime($dob)));
	return $year;
}

function success_alert($flag, $string, $err = null)
{
	if ($flag == true) {
?>
		<div class="alert alert-success" role="alert">
			<?php echo $string; ?>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-danger" role="alert">
			<?php
			foreach ($err as $value) {
			?><b><?php echo $value; ?></b><?php
										}
											?>
		</div>
	<?php
	}
}
function if_resolved_disabled_field($inc_status)
{
	if ($inc_status == 'Resolved' || $inc_status == "Cancelled")
		return 'disabled';
}
function getNumberOfWeeksInMonth($year, $month)
{
	// Get the first day of the month
	$firstDayOfMonth = strtotime("$year-$month-01");

	// Get the total number of days in the month
	$daysInMonth = date('t', $firstDayOfMonth);

	// Get the day of the week for the first and last day of the month
	$firstDayOfWeek = date('w', $firstDayOfMonth);
	$lastDayOfMonth = strtotime("$year-$month-$daysInMonth");
	$lastDayOfWeek = date('w', $lastDayOfMonth);

	// Calculate the total number of weeks
	$weeksInMonth = ceil(($firstDayOfWeek + $daysInMonth - 1) / 7);

	return $weeksInMonth;
}
function getDaysOfWeek()
{
	return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
}
function getDaysOfWeekDescending() {
    return ['Sunday', 'Saturday', 'Friday', 'Thursday', 'Wednesday', 'Tuesday', 'Monday'];
}
function formatTo12HourClock($datetime) {
    // Convert the datetime string to a timestamp
    $timestamp = strtotime($datetime);
    // Format the timestamp to 12-hour time with AM/PM
    return date('h:i A', $timestamp);
}
function getWeekNumber($datetime)
{
	$date = new DateTime($datetime);
	$firstDayOfMonth = new DateTime($date->format('Y-m-01'));
	$weekNumber = (int)$date->format('W') - (int)$firstDayOfMonth->format('W') + 1;
	return $weekNumber;
}
function getWeekNumber2($datetime)
{
	return date('W', strtotime($datetime)) - date('W', strtotime(date('Y-m-01', strtotime($datetime)))) + 1;
}

function getNumberOfWeeksInMonth2($year, $month)
{
	$firstDayOfMonth = date("N", strtotime("$year-$month-01"));
	$totalDaysInMonth = date("t", strtotime("$year-$month-01"));
	return ceil(($firstDayOfMonth + $totalDaysInMonth - 1) / 7);
}
function isActiveWeek($year, $month, $weekNumber)
{
	// Get the first day of the month
	$firstDayOfMonth = strtotime("$year-$month-01");

	// Calculate the current week number within the month
	$currentWeekNumber = date('W') - date('W', $firstDayOfMonth) + 1;

	// Check if the current week number is equal to the specified week number
	if ($currentWeekNumber == $weekNumber) {
		return "active";
	} else {
		return "";
	}
}

function getNumberOfDaysInWeek($year, $month, $weekNumber)
{
	// Get the first day of the month
	$firstDayOfMonth = strtotime("$year-$month-01");

	// Get the total number of days in the month
	$daysInMonth = date('t', $firstDayOfMonth);

	// Get the day of the week for the first day of the month
	$firstDayOfWeek = date('w', $firstDayOfMonth);

	// Calculate the start and end days of the given week
	$startDayOfWeek = ($weekNumber - 1) * 7 - $firstDayOfWeek + 1;
	$endDayOfWeek = $startDayOfWeek + 6;

	// Adjust start and end days if they go beyond the month boundaries
	if ($startDayOfWeek < 1) {
		$startDayOfWeek = 1;
	}
	if ($endDayOfWeek > $daysInMonth) {
		$endDayOfWeek = $daysInMonth;
	}

	// Calculate the number of days in the week
	$numberOfDaysInWeek = $endDayOfWeek - $startDayOfWeek + 1;

	return $numberOfDaysInWeek;
}


function avatar()
{
}

function comment_li($act_user, $act_date, $act_comment, $auth_id)
{
	?>
	<li class="media">
		<a class="pull-left" href="#">
			<img class="media-object img-circle" src="asset/avatar/<?php echo $auth_id; ?>" alt="profile">
		</a>
		<div class="media-body">
			<div class="well well-lg">
				<h4 class="media-heading text-uppercase reviews"><?php echo $act_user; ?> </h4>
				<ul class="media-date  reviews list-inline">
					<li><?php echo  recent($act_date); ?></li>
				</ul>
				<p class="media-comment">
					<?php echo $act_comment; ?>
				</p>
			</div>
		</div>

	</li>
<?php
}

function log_li($act_user, $act_log, $act_date)
{
?>
	<li class="media">
		<a class="pull-left" href="#">

		</a>
		<div class="media-body">
			<div class="alert alert-success">
				<?php echo $act_user . " " . $act_log; ?><div class="pull-right"><?php echo recent($act_date); ?></div>
			</div>
		</div>

	</li>
<?php
}

//upload image validation/function Start
//
function check_image_in_folder_if_exist($folder_name, $filename)
{
	$dir = "$folder_name/";
	$list = scandir($dir);
	if (in_array($filename, $list)) {
		return true;
	} else {
		return false;
	}
}

function show_type_image($id, $ext)
{
	if ($ext == 'doc' or $ext == 'docx') {
		show_word_image($id, $ext);
	} else if ($ext == 'xls' or $ext == 'xlsx') {
		show_excel_image($id, $ext);
	} else if ($ext == 'ppt' or $ext == 'pptx') {
		show_ppoint_image($id, $ext);
	} else if ($ext == 'pdf') {
		show_pdf_image($id, $ext);
	} else {
		echo $id;
		show_default_file_image($id, $ext);
	}
}

function show_word_image($id, $ext)
{
	echo "
		 <a  href=asset/uploaded/" . $id . "." . $ext . " target='_blank'><img src='asset/images/word.png' class='img-responsive' alt='word' Terre width='75%' ></a>
	";
}
function show_excel_image($id, $ext)
{
	echo "
	 <a  href=asset/uploaded/" . $id . "." . $ext . " target='_blank'><img src='asset/images/excel.png' class='img-responsive' alt='word' Terre width='75%' ></a>
	";
}

function show_ppoint_image($id, $ext)
{
	echo "
	 <a  href=asset/uploaded/" . $id . "." . $ext . " target='_blank'><img src='asset/images/ppoint.png' class='img-responsive' alt='word' Terre width='75%' ></a>
	";
}

function show_pdf_image($id, $ext)
{
	echo "
 <a  href=asset/uploaded/" . $id . "." . $ext . " target='_blank'><img src='asset/images/pdf.png' class='img-responsive' alt='word' Terre width='75%' ></a>
	";
}

function show_default_file_image($id, $ext)
{
	echo "
     <a  href=asset/uploaded/" . $id . "." . $ext . " target='_blank'><img src='asset/images/default_file.png' class='img-responsive' alt='word' Terre width='75%' ></a>
  ";
}


function check_photo_type($photo_type)
{
	if (strpos($photo_type, 'application') !== false) {
		return $file_type = 'application';
	} else {
		return $file_type = 'image';
	}
}

function show_file_app_type_ext($ext)
{
	if ($ext == 'docx') {
		return $ext_name = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	} else if ($ext == 'doc') {
		return $ext_name = 'application/msword';
	} else if ($ext == 'xlsx') {
		return $ext_name = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	} else if ($ext == 'xls') {
		return $ext_name = 'application/vnd.ms-excel';
	} else if ($ext == 'pptx') {
		return $ext_name = 'application/vvnd.openxmlformats-officedocument.presentationml.presentation';
	} else if ($ext == 'ppt') {
		return $ext_name = 'application/vnd.ms-powerpoint';
	} else if ($ext == 'pdf') {
		return $ext_name = 'application/pdf';
	} else if ($ext == 'txt') {
		return $ext_name = 'text/plain';
	} else if ($ext == 'exe') {
		$ext_name = 'application/x-msdownload';
	} else {
		return false;
	}
}

function show_file_img_type_ext($ext)
{
	if ($ext == 'jpg' or $ext == 'jpeg') {
		return $ext_name = 'image/jpeg';
	} else if ($ext == 'png') {
		return $ext_name = 'image/png';
	} else if ($ext == 'gif') {
		return $ext_name = 'image/gif';
	} else {
		return false;
	}
}

function file_validation($input_file_ext, $file_size)
{
	if (image_file_type_validation($input_file_ext) and file_size_validation($file_size)) {
		return true;
	} else {
		return false;
	}
}

function file_size_validation($file_size)
{
	if ($file_size <= 2000000) { //2MB
		return true;
	} else {
		return false;
	}
}

function image_type_validation($ext)
{
	if ($ext == 'jpeg' or $ext == 'jpg' or $ext == 'png') {
		return true;
	} else {
		return false;
	}
}

function image_file_type_validation($input_file_ext)
{
	$input_file_ext = strtolower($input_file_ext);
	$valid_file_ext = array("jpeg", "jpg", "png", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "txt");
	if (in_array($input_file_ext, $valid_file_ext)) {
		return true;
	} else {
		return false;
	}
}
//upload image validation/function end

function if_using_mobile_device()
{

	$useragent = $_SERVER['HTTP_USER_AGENT'];

	if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))

		return true;
	else return false;
}




?>