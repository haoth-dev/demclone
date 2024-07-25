<?php
class caregiver
{
  public $dementiabn_db = null;
  public $list = array();
  public $data = null; //for returning variable
  public $log_class = null;
  public $e_log = array();
  public $success = array();

  public function __construct($pcd_id = null)
  {
    $this->connect();
    $this->log_class = new log();
    if ($pcd_id != null) {
      $this->setData($pcd_id);
    }
  }

  function connect()
  {
    $this->dementiabn_db = new mysqli(url, username, password, name); //$db is an objet, create form mysqli class..
  }

  function check_db_connect()
  {

    $connect = $this->dementiabn_db = new mysqli(url, username, password, name); //$db is an objet, create form mysqli class..
    return $connect->connect_errno;
  }

  function setData($pcd_id)
  {
    $sql = "SELECT * FROM pc_detail WHERE pcd_id='$pcd_id'";
    $run_query = $this->dementiabn_db->query($sql);
    $this->data = $run_query->fetch_assoc();
  }

  function setDatabyEmail($pcd_email)
  {
    $array = array();
    $sql = "SELECT * FROM pc_detail WHERE pcd_email='$pcd_email'";
    $run_query = $this->dementiabn_db->query($sql);
    $array = $run_query->fetch_assoc();
    return $array;
  }

  function get_all_caregiver_data()
  {
    $sql = "SELECT * FROM `pc_detail` where `pcd_level` != 'admin'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($this->list, $row);
      }
      return $this->list;
    } else {
      return false;
    }
  }

  function get_user_data($pcd_id)
  {
    $sql = "SELECT * FROM `pc_detail` WHERE `pcd_id` = '" . $pcd_id . "' ";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      $row = $run_query->fetch_assoc();
      return $row;
    } else {
      return false;
    }
  }

  function list_primary_caregiver()
  {
    $sql = "SELECT * FROM `pc_detail` WHERE `pcd_level` = 'primary'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($this->list, $row);
      }
      return $this->list;
    } else {
      return false;
    }
  } //end list_all_asset_cat()

  function list_secondary_caregiver($pcd_id)
  {
    $sql = "SELECT * FROM `pc_detail` WHERE `pcd_assign_id` = '" . $pcd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($this->list, $row);
      }
      return $this->list;
    } else {
      return false;
    }
  } //end list_all_asset_cat()

  function pcsc_status_btn_check($scd_id, $pt_id)
  {
    $checkPatientExist = $this->isPatientAssignedUnderScaregiverExist($scd_id, $pt_id);
    if ($checkPatientExist) {
      $sql = "SELECT `pcsc_status` FROM `pc_sc` WHERE `scd_id` = '" . $scd_id . "' AND pt_id = '" . $pt_id . "'";
      $run_query = $this->dementiabn_db->query($sql);
      $row = $run_query->fetch_assoc();
    } else {
      $row['pcsc_status'] = 'unset';
    }


    return $row['pcsc_status'];
  }

  function pcsc_status_btn_toggle($scd_id, $pt_id)
  {
    $status =  $this->pcsc_status_btn_check($scd_id, $pt_id);
    if ($status == 'unset' || $status == '') {
      return "fa-unlock";
    }
    if ($status == 'set') {
      return "fa-lock";
    }
  }

  function pcsc_status_update($array)
  {
    $sql = $this->insert_update_toggle($array);
    $result = $this->dementiabn_db->query($sql);
    return $result;
    /*
return $sql_test;
  */
  }


  function toggle_pcsc_status($pcsc_status)
  {
    if ($pcsc_status == 'set') {
      $pcsc_status = 'unset';
    } else if ($pcsc_status == 'unset') {
      $pcsc_status = 'set';
    }

    return $pcsc_status;
  }

  function insert_update_toggle($array)
  {
    //$sql = "";

    $scaregiverExist = $this->isScaregiverExistInAssignTable($array['scd_id']);

    if ($scaregiverExist) { //if 2nd caregiver exist in assign table
      $isScaregiverPatientAssigned = $this->isScaregiverExistWithPatient($array['scd_id']);
      if (!$isScaregiverPatientAssigned) { //if patient not exist
        $pcsc_id = $this->getIDForFirstPatientAssignment(@$array['pcd_id'], @$array['scd_id']);
        $sql = "UPDATE `pc_sc` SET  `pcsc_status` ='set',
                                      `pt_id` = '" . @$array['pt_id'] . "' WHERE 
                                      `pcsc_id`  = '" . @$pcsc_id . "'";
      } else { //if patient exist
        $patientExistWithScaregiver = $this->isPatientAssignedUnderScaregiverExist($array['scd_id'], $array['pt_id']);
        if ($patientExistWithScaregiver) { //if patient exist and kana assigned udah
          $pcsc_status = $this->toggle_pcsc_status($array['pcsc_status']);
          $sql = "UPDATE `pc_sc` SET  `pcsc_status` ='" . $pcsc_status . "' WHERE 
                                            `pt_id`  = '" . @$array['pt_id'] . "' AND `scd_id` = '" . @$array['scd_id'] . "'";
        } else { //if patient exist tapi balum kana assigned to 2nd caregiver
          $sql = "INSERT INTO `pc_sc` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                      scd_id ='" . @$array['scd_id'] . "',
                                      pt_id='" . @$array['pt_id'] . "',
                                      pcsc_status	='set',
                                      pcsc_date='" . servDate() . "'";
        }
      }
    } else {
      $sql = "INSERT INTO `pc_sc` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                      scd_id ='" . @$array['scd_id'] . "',
                                      pt_id='" . @$array['pt_id'] . "',
                                      pcsc_status	='set',
                                      pcsc_date='" . servDate() . "'";
    }

    return $sql;
  }

  function isScaregiverExistInAssignTable($scd_id)
  {
    $sql = "SELECT * FROM `pc_sc` WHERE `scd_id` = '" . $scd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  function getIDForFirstPatientAssignment($pcd_id, $scd_id)
  {
    $sql = "SELECT `pcsc_id` FROM `pc_sc` WHERE `scd_id` = '" . $scd_id . "' AND `pcd_id` = '" . $pcd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    $row = $run_query->fetch_assoc();
    return $row['pcsc_id'];
  }

  function isScaregiverExistWithPatient($scd_id)
  {
    $sql = "SELECT * FROM `pc_sc` WHERE `scd_id` = '" . $scd_id . "' AND `pt_id` > 0";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return  true;
    } else {
      return false;
    }
  }

  function isPatientAssignedUnderScaregiverExist($scd_id, $pt_id)
  {
    $sql = "SELECT * FROM `pc_sc` WHERE `scd_id` = '" . $scd_id . "' AND `pt_id` = '" . $pt_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return  true;
    } else {
      return false;
    }
  }


  function insert_pcaregiver($array)
  {
    if ($this->isUserExist(@$array['email'])) { //for validation
      array_push($this->e_log, "User Existed! user data register failed");
      return false;
    } else {
      $sql = "INSERT INTO `pc_detail` SET  pcd_ic ='" . @$array['ic'] . "',
                                        pcd_name='" . @$array['fullname'] . "',
                                        pcd_dob='" . @$array['dob'] . "',
                                        pcd_email='" . @$array['email'] . "',
                                        pcd_contact='" . @$array['contactno'] . "',
                                        pcd_addr='" . @$array['address'] . "',
                                        pcd_level='primary'";
      $insert = $this->dementiabn_db->query($sql);
      $register_login = $this->insert_login(@$array['email'], @$array['password']);

      if ($insert && $register_login) {
        return true;
      } else {
        echo $sql;
        return false;
      }
    }
  } //end insert_ass_user

  function insert_pcaregiver_with_photo($array)
  {
    if ($this->isUserExist(@$array['email'])) { //for validation
      array_push($this->e_log, "User Existed! user data register failed");
      return false;
    } else {

      $sql = "INSERT INTO `pc_detail` SET  pcd_ic ='" . @$array['pcd_ic'] . "',
                                        pcd_name='" . @$array['pcd_name'] . "',
                                        pcd_dob='" . @$array['pcd_dob'] . "',
                                        pcd_email='" . @$array['pcd_email'] . "',
                                        pcd_contact='" . @$array['pcd_contact'] . "',
                                        pcd_addr='" . @$array['pcd_addr'] . "',
                                        pcd_level='primary'";
      $insert = $this->dementiabn_db->query($sql);
      $pcd_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
      $register_login = $this->insert_login(@$array['pcd_email'], @$array['password']);
      $folderPath = "asset/photo/";
      $photoId =  $pcd_id;
      if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
        //delete photo
        $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
        //add new photo
        if ($isPhotoDeleted) {
          $pcd_photo_path =  $this->caregiver_upload_photo($photoId);
        }
        //update data
      } else { //if photo not exist
        //add new photo
        $pcd_photo_path = $this->caregiver_upload_photo($photoId);
      }

      $update_photo = $this->update_photo_path_field($photoId, $pcd_photo_path);

      if ($insert && $register_login) {
        return true;
      } else {
        echo $sql;
        return false;
      }
    }
  } //end insert_ass_user

  function update_caregiver_data($array)
  {
    $folderPath = "asset/photo/";
    $photoId = $array['pcd_id'];
    if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
      //delete photo
      $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
      //add new photo
      if ($isPhotoDeleted) {
        $pcd_photo_path =  $this->caregiver_upload_photo($photoId);
      }
      //update data
    } else { //if photo not exist
      //add new photo
      $pcd_photo_path = $this->caregiver_upload_photo($photoId);
    }

    $sql = "UPDATE `pc_detail` SET pcd_ic='" . @$array['pcd_ic'] . "',
                              pcd_name='" . @$array['pcd_name'] . "',
                              pcd_dob='" . @$array['pcd_dob'] . "',
                              pcd_contact='" . @$array['pcd_contact'] . "',
                              pcd_photo_path='" .  $pcd_photo_path  . "',
                              pcd_addr='" . @$array['pcd_addr'] . "' WHERE pcd_id = '" . @$array['pcd_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    $registered_email = $array['pcd_email'];

    $email_name_creator = $_SESSION['pcd_email'];
    if ($update) {
      $this->log_class->capture_event_log("{$email_name_creator} successfully updated {$registered_email} data");
      return true;
    } else {
      $this->log_class->capture_event_log("{$email_name_creator} failed to update {$registered_email} data");
      $error = "User update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }



  function caregiver_upload_photo($photo_name)
  {
    // Directory where the file will be saved
    $targetDir = "asset/photo/";

    // Get the new file name from the input
    $newFileName = $photo_name;
    $imageFileType = strtolower(pathinfo($_FILES["caregiver_photo"]["name"], PATHINFO_EXTENSION));
    $newFileNameWithExtension = $newFileName . '.' . $imageFileType;
    $targetFile = $targetDir . $newFileNameWithExtension;
    $uploadOk = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["caregiver_photo"]["tmp_name"]);
    if ($check !== false) {
      // echo "File is an image - " . $check["mime"] . ".<br>";
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
    if ($_FILES["caregiver_photo"]["size"] > 5000000) {
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
      if (move_uploaded_file($_FILES["caregiver_photo"]["tmp_name"], $targetFile)) {
        return  $targetFile;
      } else {

        array_push($this->e_log, "Sorry, there was an error uploading your file.<br>");
        return false;
      }
    }
  }



  function delete_scaregiver($scd_email)
  {
    //delete scaregiver from detail table
    $detail_delete =  $this->delete_scaregiver_detail($scd_email);

    //delete scaregiver from login table
    $account_delete = $this->delete_scaregiver_login($scd_email);

    if ($detail_delete) {
      if ($account_delete) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  function delete_scaregiver_detail($email)
  {
    $sql = "DELETE FROM pc_detail WHERE pcd_email = '$email'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query) {
      return true;
    } else {
      return false;
    }
  }

  function delete_scaregiver_login($email)
  {
    $loginObj = new login();
    $delete_result = $loginObj->delete_login_data($email);
    if ($delete_result) {
      return true;
    } else {
      return false;
    }
  }


  function insert_scaregiver($array)
  {
    if ($this->isUserExist(@$array['email'])) { //for validation
      array_push($this->e_log, "User Existed! user data register failed");
      return false;
    } else {
      $sql = "INSERT INTO `pc_detail` SET  pcd_ic ='" . @$array['ic'] . "',
                                      pcd_assign_id='" . @$array['pcd_assign_id'] . "',
                                      pcd_name='" . @$array['fullname'] . "',
                                      pcd_dob='" . @$array['dob'] . "',
                                      pcd_email='" . @$array['email'] . "',
                                      pcd_contact='" . @$array['contactno'] . "',
                                      pcd_addr='" . @$array['address'] . "',
                                      pcd_photo_path='',
                                      pcd_level='secondary'";

      $insert = $this->dementiabn_db->query($sql); //run query to insert scd data 
      $scd_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
      $photo_path = profile_upload_photo($scd_id); //upload photo and name the photo as scd_id
      $update_photo = $this->update_photo_path_field($scd_id, $photo_path); //update the photo path on scd/pcd table detail
      $register_login = $this->insert_login(@$array['email'], @$array['password']); //insert username and password on login table
      $assignArr = array(); //create array for assign pc_sc table
      $assignArr['pcd_id'] = @$array['pcd_assign_id'];
      $assignArr['scd_id'] = $scd_id;
      $assignArr['pcsc_status'] = 'unset';
      $assignArr['pcsc_date'] = servDate();
      $pcsc_id =  $this->save_scaregiver_for_patient($assignArr); //add secondary giver to assign table for assigning to pwd later. 
      $pcsc_assign_id = "$pcsc_id$scd_id";

      $registered_email = $array['email'];
      $email_name_creator = $_SESSION['pcd_email'];
      if ($insert && $register_login) {
        $this->log_class->capture_event_log("{$email_name_creator} succesfully added {$registered_email} data to Database");
        return true;
      } else {
        $this->log_class->capture_event_log("{$email_name_creator} failed to added {$registered_email} data to Database");
        return false;
      }
    }
  } //end insert_ass_user

  function update_photo_path_field($pcd_id, $photo_path)
  {
    $sql = "UPDATE `pc_detail` SET  `pcd_photo_path` ='" . $photo_path . "'  WHERE `pcd_id`  = '" . @$pcd_id . "'";
    $update = $this->dementiabn_db->query($sql);
    $caregiverObj = new caregiver($pcd_id);
    $caregiver_email = $caregiverObj->data['pcd_email'];
    $email_name = $_SESSION['pcd_email'];
    if ($update) {
      $this->log_class->capture_event_log("{$email_name} succesfully upload profile photo for {$caregiver_email}");
      return true;
    } else {
      $this->log_class->capture_event_log("{$email_name} failed to upload profile photo for {$caregiver_email}");
      $err = "Failed to upload photo";
      array_push($this->e_log, $err);
      return false;
    }
  }

  function insert_login($pcd_email, $password)
  {
    $sql = "INSERT INTO `login` SET  l_username ='" . @$pcd_email . "',
                                    l_pass='" . @$password . "',
                                    l_status='active'";
    $insert = $this->dementiabn_db->query($sql);
    $registered_email = $pcd_email;
    if (!empty($_SESSION['pcd_email'])) {
      $email_name_creator = $_SESSION['pcd_email'];
    } else {
      $email_name_creator = "DementiaBN";
    }

    if ($insert) {
      $this->log_class->capture_event_log("login account succesfully created by {$email_name_creator} for {$registered_email}");
      return true;
    } else {
      $this->log_class->capture_event_log("login account creation failed by {$email_name_creator} for {$registered_email}");
      return false;
    }
  }

  function isUserExist($pcd_email)
  {
    $sql = "SELECT * FROM `pc_detail` WHERE `pcd_email` = '" . $pcd_email . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  function save_scaregiver_for_patient($array)
  {
    $sql = "INSERT INTO `pc_sc` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                  scd_id ='" . @$array['scd_id'] . "',
                                  pcsc_status	='" . @$array['pcsc_status'] . "',
                                  pcsc_date='" . servDate() . "'";
    $insert = $this->dementiabn_db->query($sql);
    $registered_email = $array['scd_id'];
    $email_name_creator = $_SESSION['pcd_email'];
    if ($insert) {
      $this->log_class->capture_event_log("{$email_name_creator} succesfully registered {$registered_email} as his/her secondary caregiver ");
      $pcsc_id =  $this->dementiabn_db->insert_id;
      return $pcsc_id;
    } else {
      $this->log_class->capture_event_log("{$email_name_creator} failed to registered {$registered_email} as his/her secondary caregiver ");
      return false;
    }
  }

  function assign_scaregiver_to_patient($array)
  {
    $sql = "INSERT INTO `pc_sc` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                        scd_id ='" . @$array['scd_id'] . "',
                                        pt_id='" . @$array['pt_id'] . "',
                                        pcsc_status	='" . @$array['pcsc_status'] . "',
                                        pcsc_date='" . servDate() . "'";
    $insert = $this->dementiabn_db->query($sql);
    return $insert;
  }

  function update_assign_id($pcsc_assign_id, $pcsc_id)
  {
    $sql = "UPDATE `pc_sc` SET  `pcsc_assign_id` ='" . $pcsc_assign_id . "'  WHERE `pcsc_id`  = '" . $pcsc_id . "'";
    $update = $this->dementiabn_db->query($sql);
  }




  function insert_user_using_edit($array)
  {
    $sql = "UPDATE `user` SET  `u_dept_id` ='" . @$array['u_dept_id'] . "',
                              `u_ind_no` = '" . @$array['u_ind_no'] . "' WHERE `u_email`  = '" . @$array['user_email'] . "";

    $update = $this->dementiabn_db->query($sql);
  }

  function update_user_data($array)
  {
    $sql = "UPDATE `user` SET  `d_acr` ='" . @$array['d_acr'] . "',
                              `u_ind_no` = '" . @$array['u_ind_no'] . "',
                              `u_title` = '" . @$array['u_title'] . "' WHERE `u_email`  ='" . @$array['u_email'] . "'";

    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      return true;
    } else {
      $error = "User update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }

  function insertGuest($array)
  {
    $sql = "INSERT INTO `pc_detail` SET  pcd_name ='" . @$array['pcd_name'] . "',
                                      pcd_contact ='" . @$array['pcd_contact'] . "',
                                      pcd_email	='" . @$array['pcd_email'] . "',
                                      pcd_level='guest'";
    $insert = $this->dementiabn_db->query($sql);

    if ($insert) {
      return true;
    } else {
      $error = "Guest data failed to insert to DB";
      array_push($this->e_log, $error);
      return false;
    }
  }


  //user foreign table

  function check_task_based_on_u_email($u_email)
  {
    $sql = "SELECT * FROM `task` WHERE `u_email` = '$u_email'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      array_push($this->e_log, "No Asset Assigned to this User yet!!");
    }
  }

  function clear_caregiver_data()
  {
    $sql = "DELETE FROM pc_detail";
    $result = $this->dementiabn_db->query($sql);

    if ($result) {
      return true;
    } else {
      $error = "Error deleting pc_detail to Database";
      array_push($this->e_log, $error);
      return false;
    }
  }
}
