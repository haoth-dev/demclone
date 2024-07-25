<?php
class login
{
	public $dementiabn_db = null;
	public $list = array();
	public $data = null; //for returning variable
	public $log_class = null;
	public $e_log = array();
	public $success = array();

	public function __construct($pcd_email = null)
	{
		$this->connect();
		$this->log_class = new log();
		if ($pcd_email != null) {
			$this->setData($pcd_email);
		}
	}
	function connect()
	{
		$this->dementiabn_db = new mysqli(url, username, password, name); //$db is an objet, create form mysqli class..

		if ($this->dementiabn_db->connect_error) {
			array_push($this->e_log, "Connection failed: " . $this->dementiabn_db->connect_error);
			die("Connection failed: " . $this->dementiabn_db->connect_error);
		}
	}


	function login_process($username, $password)
	{
		$mysql = "SELECT * FROM login WHERE `l_username`='$username' AND `l_pass`='$password'";
		$run_query = $this->dementiabn_db->query($mysql);
		if ($run_query->num_rows > 0) { //if username ada rh db
			$careObj = new caregiver();
			$careData = $careObj->setDatabyEmail($username);
			$this->setData($username);
			$_SESSION['pcd_ic'] = $careData['pcd_ic'];
			$_SESSION['pcd_id'] = $careData['pcd_id'];
			$_SESSION['pcd_name'] = $careData['pcd_name'];
			$_SESSION['pcd_dob'] = $careData['pcd_dob'];
			$_SESSION['pcd_contact'] = $careData['pcd_contact'];
			$_SESSION['pcd_email'] = $careData['pcd_email'];
			$_SESSION['pcd_addr'] = $careData['pcd_addr'];
			$_SESSION['pcd_level'] = $careData['pcd_level'];
			$_SESSION['pcd_assign_id'] = $careData['pcd_assign_id'];
			$this->level_navigate();
			return true;
		} //end numrows
		else {
			array_push($this->e_log, "No user have been added yet");
			return false;
		}
	} //end login()
	function setData($pcd_email)
	{
		$mysql = "SELECT * FROM `login` WHERE l_username='$pcd_email'";
		$run_query = $this->dementiabn_db->query($mysql);
		$this->data = $run_query->fetch_assoc();
	}
	function get_level($column, $value)
	{
		$mysql = "SELECT * FROM `pc_detail` WHERE `$column` ='$value'";
		$run_query = $this->dementiabn_db->query($mysql);
		$rows = $run_query->fetch_assoc();
		return $rows['pcd_level'];
	} //end get_leve()


	function level_navigate()
	{
		$email = $_SESSION['pcd_email'];
		$this->log_class->capture_access_log("$email succesfully logged in to DementiaBN");
		if ($_SESSION['pcd_level'] == 'admin') {
			header('Location: admin_nav_page.php');
		}
		if ($_SESSION['pcd_level'] != 'admin') {
			header('Location: nav_page.php');
		}
	}



	function delete_login_data($email)
	{
		$sql = "DELETE FROM `login` WHERE l_username = '$email'";
		$run_query = $this->dementiabn_db->query($sql);
		if ($run_query) {
			$check_username_exist = $this->isUsernameExist($email);
			if ($check_username_exist) {
				return false; //delete failed pasal user masih exist rh login table
			} else {
				return true; //delete succuss
			}
		}
	}

	function isUsernameExist($email)
	{
		$sql = "SELECT * FROM `login` WHERE `l_username` = '" . $email . "'";
		$run_query = $this->dementiabn_db->query($sql);
		if ($run_query->num_rows > 0) {
			return  true;
		} else {
			return false;
		}
	}

	function get_email_name($email)
	{
		$parts = explode('@', $email);
		// Return the part before the '@' symbol
		return $parts[0];
	}

	function update_password($l_username, $current_pass, $new_pass, $confirm_pass)
	{
		if ($this->pass_update_validation($l_username, $current_pass, $new_pass, $confirm_pass)) {
			$sql = "UPDATE `login` SET `l_pass` = '" . $new_pass . "' WHERE `l_username` = '$l_username'";
			$run_query = $this->dementiabn_db->query($sql);
			if ($run_query) {
				$this->log_class->capture_event_log("{$l_username} successfully updated password");
				return  true;
			} else {
				$this->log_class->capture_event_log("update query failed when {$l_username} attempt to update password");
				return false;
			}
		} else {
			$this->log_class->capture_event_log("validation failed when {$l_username} attempt to update password");
			return false;
		}
	}


	function pass_update_validation($l_username, $current_pass, $new_pass, $confirm_pass)
	{
		if ($this->confirm_new_password($new_pass, $confirm_pass) == false) {
			$error = "Password Mismatch with new Password";
			array_push($this->e_log, $error);
			return false;
		} else if ($this->confirm_current_password($l_username, $current_pass) == false) {
			//nda sama dgn current password yg kana stored rh db
			$error = "Password Mismatch with Current password";
			array_push($this->e_log, $error);
			return false;
		} else {
			return true;
		}
	}

	function confirm_new_password($new_pass, $confirm_pass)
	{
		if ($new_pass == $confirm_pass) {
			return true;
		} else {

			return false;
		}
	}

	function confirm_current_password($l_username, $current_pass)
	{
		$loginObj = new login($l_username);
		$l_pass = $loginObj->data['l_pass'];
		if ($l_pass == $current_pass) {
			return true;
		} else {

			return false;
		}
	}
}
