<?php
require_once("config/config.php");
require_once("function/custom_function.php");


function alert($string)
{
	echo "<SCRIPT>alert('$string')</SCRIPT>";
}

function alert2($flag = null, $string)
{
	if ($flag) echo "<script>
	alert('$string');
	</script>
	";
}

function view_array($array)
{
	$text = print_r($array, true);
	if (dev_mode) echo "<pre>" . $text . "</pre>";
}
function servDate()
{
	return date('Y-m-d G:i:s');
}

function is_datetime_not_set($datetime)
{
	return $datetime === '0000-00-00 00:00:00' || is_null($datetime);
}


function get_email_prefix($email)
{
	$parts = explode('@', $email);
	return $parts[0];
}

function recent($recent)
{
	$from = strtotime($recent);
	$to = strtotime(servDate());
	$time = round(abs($to - $from) / 60, 2);
	$from = strtotime($recent);
	$to = strtotime(servDate());
	$time = round(abs($to - $from) / 60, 2);

	if ($time > 44640) {
		return $recent;
	} else if ($time > 1440) {
		return $time = round(abs($to - $from) / 86400, 0) . " day(s) ago";
	} else if ($time > 60) {
		return $time = round(abs($to - $from) / 3600, 0) . " hour(s) ago";
	} else if ($time > 0) {
		return $time = round(abs($to - $from) / 60, 0) . " minute(s) ago";
	} else {
		return "A while ago";
	}
}
function randomtoken()
{
	$character = "abcdefghijklmnopqrstuwxyz0123456789";
	$token = '';
	$charlength = strlen($character) - 1;
	for ($i = 0; $i < 4; $i++) {
		$n = mt_rand(0, $charlength);
		$token = $token . $character[$n];
	}
	return ($token);
}

function ar_mail2($email, $subject, $message)
{
	require_once 'module/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;   //create object called $mail

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = email_username;                 // SMTP username
	$mail->Password = email_password;                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to
	$mail->Timeout = 60;
	$mail->Priority    = 1;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);                               // TCP port to connect to


	$mail->setFrom(email_username, email_name);
	$mail->addAddress($email);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo(email_username, 'Information');
	$mail->addCC('');
	$mail->addBCC('');


	$mail->addAttachment('', '');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$sent_alert = 'The message is successfully sent to the sender!!!!!';

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	return $mail->send();
} //end ar mail 2

function ar_mail_attach($email, $subject, $message, $path_attachment = null, $file_attachment_name = null)
{
	require_once 'module/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;   //create object called $mail

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = email_username;                 // SMTP username
	$mail->Password = email_password;                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to
	$mail->Timeout = 60;
	$mail->Priority    = 1;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);                               // TCP port to connect to


	$mail->setFrom(email_username, email_name);
	$mail->addAddress($email);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo(email_username, 'Information');
	$mail->addCC('');
	$mail->addBCC('');

	if ($path_attachment != null and $file_attachment_name != null) {
		$mail->addAttachment($path_attachment, $file_attachment_name);    // Optional name.
	}

	$mail->isHTML(true);                                  // Set email format to HTML

	$sent_alert = 'The message is successfully sent to the sender!!!!!';

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	return $mail->send();
} //end ar mail attach

function ar_mail_mutiple_user($email_array, $subject, $message, $path_attachment = null, $file_attachment_name = null)
{
	require_once 'module/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;   //create object called $mail

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = email_username;                 // SMTP username
	$mail->Password = email_password;                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to
	$mail->Timeout = 60;
	$mail->Priority    = 1;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);                               // TCP port to connect to


	$mail->setFrom(email_username, email_name);
	foreach ($email_array as $key => $email) {
		$mail->addAddress($email);     // Add a recipient
	}

	//$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo(email_username, 'Information');
	$mail->addCC('');
	$mail->addBCC('');

	if ($path_attachment != null and $file_attachment_name != null) {
		$mail->addAttachment($path_attachment, $file_attachment_name);    // Optional name.
	}

	$mail->isHTML(true);                                  // Set email format to HTML

	$sent_alert = 'The message is successfully sent to the sender!!!!!';

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	return $mail->send();
} //end ar mail mutiple user

function api_get($url)
{
	return file_get_contents($url);
}

function selection_equal($string1, $string2)
{
	if ($string1 == $string2) return  " selected ";
}

function ar_mail($email, $subject, $message)
{
	require_once 'module/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer();   //create object called $mail

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = email_username;                 // SMTP username
	$mail->Password = email_password;                        // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to
	$mail->Timeout = 60;
	$mail->Priority    = 1;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	$mail->setFrom(email_username, email_name);
	$mail->addAddress($email);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	$mail->addReplyTo(email_username, 'Information');
	// $mail->addCC($email);
	// $mail->addBCC($email);


	// $mail->addAttachment('', '');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$sent_alert = 'The message is successfully sent to the sender!!!!!';

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


	return $mail->send();
}



function export_doc($rq_title)
{

	header("Content-Type: application/vnd.msword");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=" . $rq_title . ".doc");
}

function qr_code_gen($pt_id)
{

	include('module/phpqrcode/qrlib.php');
	//include('config.php');

	// how to save PNG codes to server

	$tempDir = "asset/qr/";

	$codeContents = "http://localhost/dementiabn/missing_pt.php?pt_id='" . $pt_id . "'";

	// we need to generate filename somehow, 
	// with md5 or with database ID used to obtains $codeContents...
	$fileName = '"' . $pt_id . '"_file_' . md5($codeContents) . '.png';

	$pngAbsoluteFilePath = $tempDir . $fileName;
	$urlRelativeFilePath = $tempDir . $fileName;

	// generating
	if (!file_exists($pngAbsoluteFilePath)) {
		QRcode::png($codeContents, $pngAbsoluteFilePath);
		return true;
	} else {
		return false;
	}
}

function profile_upload_photo($photo_name)
{
	// Directory where the file will be saved
	$targetDir = "asset/photo/";

	// Get the new file name from the input
	$newFileName = $photo_name;
	$imageFileType = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
	$newFileNameWithExtension = $newFileName . '.' . $imageFileType;
	$targetFile = $targetDir . $newFileNameWithExtension;
	$uploadOk = 1;

	// Check if file is an actual image or fake image
	$check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
	if ($check !== false) {
		echo "File is an image - " . $check["mime"] . ".<br>";
		$uploadOk = 1;
	} else {
		echo "File is not an image.<br>";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($targetFile)) {
		echo "Sorry, file already exists.<br>";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["profile_photo"]["size"] > 5000000) {
		echo "Sorry, your file is too large.<br>";
		$uploadOk = 0;
	}

	// Allow certain file formats
	$allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
	if (!in_array($imageFileType, $allowedFormats)) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.<br>";
	} else {
		// Try to upload file
		if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
			return  $targetFile;
		} else {
			return false;
		}
	}
}
function sanitizeFileName($filename)
{
	return preg_replace('/[^a-zA-Z0-9\._-]/', '_', $filename);
}

function isValidImage($file)
{
	$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
	return in_array($file['type'], $allowedTypes);
}

function profile_upload_photo_ajax($photo_name)
{
	$targetDir = "asset/photo/";
	$imageFileType = strtolower(pathinfo($_FILES["userImage"]["name"], PATHINFO_EXTENSION));
	$newFileNameWithExtension = sanitizeFileName($photo_name) . '.' . $imageFileType;
	$targetFile = $targetDir . $newFileNameWithExtension;
	$uploadOk = 1;

	if ($check = getimagesize($_FILES["userImage"]["tmp_name"])) {
		$uploadOk = 1;
	} else {
		return "File is not an image.";
	}

	if (file_exists($targetFile)) {
		return "Sorry, file already exists.";
	}

	if ($_FILES["userImage"]["size"] > 5000000) {
		return "Sorry, your file is too large.";
	}

	$allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
	if (!in_array($imageFileType, $allowedFormats)) {
		return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	}

	if ($uploadOk && move_uploaded_file($_FILES["userImage"]["tmp_name"], $targetFile)) {
		return ['path' => $targetFile, 'message' => '<img class="image-preview" src="' . $targetFile . '" class="upload-preview" />'];
	} else {
		return "Sorry, your file was not uploaded.";
	}
}


function scanImagesInFolder($folderPath, $photoId)
{
	// Check if the folder exists and is readable
	if (!is_dir($folderPath) || !is_readable($folderPath)) {
		return false;
	}

	// Convert photoId to string for consistent comparison
	$photoId = (string)$photoId;

	// Define common image file extensions
	$imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	// Open the directory
	$dirHandle = opendir($folderPath);

	if ($dirHandle) {
		// Loop through the directory entries
		while (($entry = readdir($dirHandle)) !== false) {
			// Skip '.' and '..' entries
			if ($entry != '.' && $entry != '..') {
				// Get the file extension
				$fileExtension = pathinfo($entry, PATHINFO_EXTENSION);

				// Check if the file extension is in the list of image extensions
				if (in_array(strtolower($fileExtension), $imageExtensions)) {
					// Get the file name without extension
					$fileNameWithoutExtension = pathinfo($entry, PATHINFO_FILENAME);

					// Check if the file name matches the photo ID
					if ($fileNameWithoutExtension === $photoId) {
						closedir($dirHandle);
						return true;
					}
				}
			}
		}

		// Close the directory handle
		closedir($dirHandle);
	}

	// Return false if the photo ID was not found
	return false;
}

function deletePhotoInFolder($folderPath, $photoId)
{
	// Check if the folder exists and is readable
	if (!is_dir($folderPath) || !is_readable($folderPath)) {
		return false;
	}

	// Convert photoId to string for consistent comparison
	$photoId = (string)$photoId;

	// Define common image file extensions
	$imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	// Open the directory
	$dirHandle = opendir($folderPath);

	if ($dirHandle) {
		// Loop through the directory entries
		while (($entry = readdir($dirHandle)) !== false) {
			// Skip '.' and '..' entries
			if ($entry != '.' && $entry != '..') {
				// Get the file extension
				$fileExtension = pathinfo($entry, PATHINFO_EXTENSION);

				// Check if the file extension is in the list of image extensions
				if (in_array(strtolower($fileExtension), $imageExtensions)) {
					// Get the file name without extension
					$fileNameWithoutExtension = pathinfo($entry, PATHINFO_FILENAME);

					// Check if the file name matches the photo ID
					if ($fileNameWithoutExtension === $photoId) {
						// Build the full file path
						$filePath = $folderPath . DIRECTORY_SEPARATOR . $entry;

						// Delete the file
						if (unlink($filePath)) {
							closedir($dirHandle);
							return true;
						} else {
							closedir($dirHandle);
							return false;
						}
					}
				}
			}
		}

		// Close the directory handle
		closedir($dirHandle);
	}

	// Return false if the photo ID was not found
	return false;
}
