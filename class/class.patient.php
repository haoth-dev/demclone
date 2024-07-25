<?php
class patient
{
  public $dementiabn_db = null;
  public $list = array();
  public $log_class = null;
  public $data = null; //for returning variable
  public $e_log = array();
  public $success = array();

  public function __construct($pt_id = null)
  {
    $this->connect();
    $this->log_class = new log();
    if ($pt_id != null) {
      $this->setData($pt_id);
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

  function setData($pt_id)
  {
    $sql = "SELECT * FROM patient WHERE pt_id='$pt_id'";
    $run_query = $this->dementiabn_db->query($sql);
    $this->data = $run_query->fetch_assoc();
  }

  function get_user_data($pt_id)
  {
    $sql = "SELECT * FROM `patient` WHERE `pt_id` = '" . $pt_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      $row = $run_query->fetch_assoc();
      return $row;
    } else {
      return false;
    }
  }
  function list_all_patient()
  {
    $sql = "SELECT * FROM `patient`";
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

  function list_all_patient_by_pcdID($pcd_id)
  {
    $pat_list = array();
    $sql = "SELECT * FROM `patient` where `pcd_id` = '" . $pcd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($pat_list, $row);
      }
      return $pat_list;
    } else {
      return false;
    }
  } //end list_all_asset_cat()

  function list_all_patient_by_scdID($scd_id)
  {
    $sql = "SELECT * FROM `pc_sc` where `scd_id` = '" . $scd_id . "' AND pcsc_status = 'set'";
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

  function insert_patient_admin($array)
  {
    if ($this->isPatientExist(@$array['pt_ic'])) { //for validation
      array_push($this->e_log, "User Existed! Enter patient with different IC");
      return false;
    } else {
      $sql = "INSERT INTO `patient` SET  pt_ic ='" . @$array['pt_ic'] . "',
                                        pt_name='" . @$array['pt_name'] . "',
                                        pt_dob='" . @$array['pt_dob'] . "',
                                        dt_id='" . @$array['dt_id'] . "',
                                        pt_stage='" . @$array['pt_stage'] . "',
                                        pt_relationship='" . @$array['pt_relationship'] . "',
                                        pt_location='" . @$array['pt_location'] . "',
                                        pt_remark='" . @$array['pt_remark'] . "',
                                        pt_qr_path='',
                                        pcm_id ='',
                                        pcd_id='" . @$array['pcd_id'] . "'";
      $insert = $this->dementiabn_db->query($sql);
      $pt_id = $this->dementiabn_db->insert_id; //kan d masukkan dalam qrcode function 


      //generate qr code
      $pt_qr_path = $this->pt_qr_code_gen($pt_id);
      $pt_photo_path = $this->patient_upload_photo($pt_id);
      //udpate qrcode directory to patient table. 
      $update_qr = $this->update_qrcode_field($pt_id, $pt_qr_path);
      $update_photo = $this->update_photo_path_field($pt_id, $pt_photo_path);


      //for log
      $loginObj = new login();
      $email_name = $loginObj->get_email_name($_SESSION['pcd_email']);
      if ($insert) {

        $this->log_class->capture_event_log("{$email_name} successfully added new PWD!");
        return true;
      } else {
        $this->log_class->capture_event_log("{$email_name} falied to added new PWD!");
        array_push($this->e_log, "Failed to add POD to DB");
        return false;
      }
    }
  } //end insert_ass_user

  function insert_patient($array)
  {
    if ($this->isPatientExist(@$array['pt_ic'])) { //for validation
      array_push($this->e_log, "User Existed! Enter patient with different IC");
      return false;
    } else {
      $sql = "INSERT INTO `patient` SET  pt_ic ='" . @$array['pt_ic'] . "',
                                        pt_name='" . @$array['pt_name'] . "',
                                        pt_dob='" . @$array['pt_dob'] . "',
                                        dt_id='" . @$array['dt_id'] . "',
                                        pt_stage='" . @$array['pt_stage'] . "',
                                        pt_relationship='" . @$array['pt_relationship'] . "',
                                        pt_location='" . @$array['pt_location'] . "',
                                        pt_remark='" . @$array['pt_remark'] . "',
                                        pt_qr_path='',
                                        pcm_id ='',
                                        pcd_id='" . @$_SESSION['pcd_id'] . "'";
      $insert = $this->dementiabn_db->query($sql);
      $pt_id = $this->dementiabn_db->insert_id; //kan d masukkan dalam qrcode function 


      //generate qr code
      $pt_qr_path = $this->pt_qr_code_gen($pt_id);
      $pt_photo_path = $this->patient_upload_photo($pt_id);
      //udpate qrcode directory to patient table. 
      $update_qr = $this->update_qrcode_field($pt_id, $pt_qr_path);
      $update_photo = $this->update_photo_path_field($pt_id, $pt_photo_path);

      if ($insert) {

        return true;
      } else {

        return false;
      }
    }
  } //end insert_ass_user

  function patient_upload_photo($photo_name)
  {
    // Directory where the file will be saved
    $targetDir = "asset/photo/";

    // Get the new file name from the input
    $newFileName = $photo_name;
    $imageFileType = strtolower(pathinfo($_FILES["pt_photo"]["name"], PATHINFO_EXTENSION));
    $newFileNameWithExtension = $newFileName . '.' . $imageFileType;
    $targetFile = $targetDir . $newFileNameWithExtension;
    $uploadOk = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["pt_photo"]["tmp_name"]);
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
    if ($_FILES["pt_photo"]["size"] > 5000000) {
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
      if (move_uploaded_file($_FILES["pt_photo"]["tmp_name"], $targetFile)) {
        return  $targetFile;
      } else {

        array_push($this->e_log, "Sorry, there was an error uploading your file.<br>");
        return false;
      }
    }
  }

  function pt_qr_code_gen($pt_id)
  {

    include('module/phpqrcode/qrlib.php');
    //include('config.php');

    // how to save PNG codes to server

    $tempDir = "asset/qr/";

    $codeContents = domain_url . "qr_index.php?pt_id=" . urlencode($pt_id);



    // we need to generate filename somehow, 
    // with md5 or with database ID used to obtains $codeContents...
    // $fileName = '"' . $pt_id . '"_file_' . md5($codeContents) . '.png';
    $fileName = "'" . $pt_id . "'_file_'" . md5($codeContents) . "'.png";
    $fileName = str_replace("'", "", $fileName);

    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = $tempDir . $fileName;

    // generating
    if (!file_exists($pngAbsoluteFilePath)) {
      QRcode::png($codeContents, $pngAbsoluteFilePath);
      return $pngAbsoluteFilePath;
    } else {
      array_push($this->e_log, "ERROR! QR CODE PATH ALREADY EXIST.");
      return false;
    }
  }

  function update_qrcode_field($pt_id, $pt_qr_path)
  {
    $sql = "UPDATE `patient` SET  `pt_qr_path` ='" . $pt_qr_path . "'  WHERE `pt_id`  = '" . @$pt_id . "'";
    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      return true;
    } else {
      array_push($this->e_log, "ERROR! QR CODE FAILED TO UPDATE TO PATIENT TABLE.");
      return false;
    }
  }

  function update_photo_path_field($pt_id, $pt_photo_path)
  {
    $sql = "UPDATE `patient` SET  `pt_photo_path` ='" . $pt_photo_path . "'  WHERE `pt_id`  = '" . @$pt_id . "'";
    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      array_push($this->e_log, $sql);
      return true;
    } else {
      array_push($this->e_log, $sql);
      return false;
    }
  }

  function insert_login($pt_ic, $password)
  {
    $sql = "INSERT INTO `login` SET  l_username ='" . @$pt_ic . "',
                                    l_pass='" . @$password . "'";
    $insert = $this->dementiabn_db->query($sql);
    return $insert;
  }

  function isPatientExist($pt_ic)
  {
    $sql = "SELECT * FROM `patient` WHERE `pt_ic` = '" . $pt_ic . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }



  function isPrimaryCaregiverPatientExist($pcd_id)
  {
    $sql = "SELECT * FROM `patient` WHERE `pcd_id` = '" . $pcd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  function update_patient_data($array)
  {

    $sql = "UPDATE `patient` SET pt_name='" . @$array['pt_name'] . "',
                              pt_dob='" . @$array['pt_dob'] . "',
                              pt_height='" . @$array['pt_height'] . "',
                              pt_weight='" . @$array['pt_weight'] . "',
                              pt_relationship='" . @$array['pt_relationship'] . "',
                              pt_location='" . @$array['pt_location'] . "',
                              pt_remark='" . @$array['pt_remark'] . "' WHERE pt_id = '" . @$array['pt_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      return true;
    } else {
      $error = "User update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }
  function admin_update_patient_data_with_photo($array)
  {
    $folderPath = "asset/photo/";
    $photoId = $array['pt_id'];
    if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
      //delete photo
      $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
      //add new photo
      if ($isPhotoDeleted) {
        $pt_photo_path =  $this->patient_upload_photo($photoId);
      }
      //update data
    } else { //if photo not exist
      //add new photo
      $pt_photo_path = $this->patient_upload_photo($photoId);
    }

    $sql = "UPDATE `patient` SET pt_name='" . @$array['pt_name'] . "',
                                  pcd_id='" . @$array['pcd_id'] . "',
                                  pt_dob='" . @$array['pt_dob'] . "',
                                  pt_relationship='" . @$array['pt_relationship'] . "',
                                  dt_id='" . @$array['dt_id'] . "',
                                  pt_stage='" . @$array['pt_stage'] . "',
                                  pt_location='" . @$array['pt_location'] . "',
                                  pt_photo_path='" . @$pt_photo_path . "',
                                  pt_remark='" . @$array['pt_remark'] . "' WHERE pt_id = '" . @$array['pt_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    //for logging data
    $pcdObj = new caregiver($array['pcd_id']);
    $pt_name = $array['pt_name'];
    if ($update) {

      $this->log_class->capture_event_log("Admin successfully update {$pt_name} data");
      return true;
    } else {
      $this->log_class->capture_event_log("Admin attempt to update {$pt_name} data but failed!");
      $error = "Patient update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }

  function update_patient_data_with_photo($array)
  {
    $folderPath = "asset/photo/";
    $photoId = $array['pt_id'];
    if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
      //delete photo
      $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
      //add new photo
      if ($isPhotoDeleted) {
        $pt_photo_path =  $this->patient_upload_photo($photoId);
      }
      //update data
    } else { //if photo not exist
      //add new photo
      $pt_photo_path = $this->patient_upload_photo($photoId);
    }

    $sql = "UPDATE `patient` SET pt_name='" . @$array['pt_name'] . "',
                                  pt_dob='" . @$array['pt_dob'] . "',
                                  pt_relationship='" . @$array['pt_relationship'] . "',
                                  dt_id='" . @$array['dt_id'] . "',
                                  pt_stage='" . @$array['pt_stage'] . "',
                                  pt_location='" . @$array['pt_location'] . "',
                                  pt_photo_path='" . @$pt_photo_path . "',
                                  pt_remark='" . @$array['pt_remark'] . "' WHERE pt_id = '" . @$array['pt_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    //for logging data
    $pcdObj = new caregiver($array['pcd_id']);
    $email_name = $pcdObj->data['pcd_email'];
    $pt_name = $array['pt_name'];
    if ($update) {

      $this->log_class->capture_event_log("{$email_name} successfully update {$pt_name} data");
      return true;
    } else {
      $this->log_class->capture_event_log("{$email_name} attempt to update {$pt_name} data but failed!");
      $error = "User update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }




  function insert_user_using_edit($array)
  {
    $sql = "UPDATE `user` SET  `u_dept_id` ='" . @$array['u_dept_id'] . "',
                              `u_ind_no` = '" . @$array['u_ind_no'] . "' WHERE `u_email`  = '" . @$array['user_email'] . "'";

    $update = $this->dementiabn_db->query($sql);
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
}
