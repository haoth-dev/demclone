<?php
class medication
{
  public $dementiabn_db = null;
  public $list = array();
  public $data = null; //for returning variable
  public $log_class = null;
  public $e_log = array();
  public $success = array();

  public function __construct($meds_id = null, $pcm_id = null)
  {
    $this->connect();
    $this->log_class = new log();
    if ($meds_id != null) {
      $this->setData($meds_id);
    }
    if ($pcm_id != null) {
      $this->setPCMData($pcm_id);
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

  function setData($meds_id)
  {
    $sql = "SELECT * FROM medication WHERE meds_id='$meds_id'";
    $run_query = $this->dementiabn_db->query($sql);
    $this->data = $run_query->fetch_assoc();
  }

  function setPCMData($pcm_id)
  {
    $sql = "SELECT * FROM pc_meds WHERE pcm_id='$pcm_id'";
    $run_query = $this->dementiabn_db->query($sql);
    $this->data = $run_query->fetch_assoc();
  }

  function get_meds_name_only($meds_id)
  {
    $sql = "SELECT `meds_name` FROM `medication` WHERE `meds_id` = '" . $meds_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    $row = $run_query->fetch_assoc();
    return $row['meds_name'];
  }

  function get_meds_data($meds_id)
  {
    $sql = "SELECT * FROM `medication` WHERE `meds_id` = '" . $meds_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      $row = $run_query->fetch_assoc();
      return $row;
    } else {
      return false;
    }
  }
  function list_all_meds()
  {
    $sql = "SELECT * FROM `medication`";
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


  function list_meds_by_pcd($pcd_id)
  {
    $sql = "SELECT * FROM `medication` WHERE `pcd_id` = '" . $pcd_id . "'";
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

  function insert_medication($array)
  {
    $email_name_creator = $_SESSION['pcd_email'];
    if ($this->isMedsExist(@$array['meds_name'], @$_SESSION['pcd_id'])) { //for validation
      $this->log_class->capture_event_log("{$email_name_creator} failed to add {$array['meds_name']} to Medication table");
      array_push($this->e_log, "Medication existed already, please enter different medication name");
      return false;
    } else {
      $sql = "INSERT INTO `medication` SET  meds_name ='" . @$array['meds_name'] . "',
                                        meds_desc='" . @$array['meds_desc'] . "',
                                        meds_added_date	='" . servDate() . "',
                                        pcd_id='" . @$_SESSION['pcd_id'] . "'";

      $insert = $this->dementiabn_db->query($sql);
      if ($insert) {
        $this->log_class->capture_event_log("{$email_name_creator} successfully add {$array['meds_name']} to Medication table");
        return true;
      } else {
        $this->log_class->capture_event_log("{$email_name_creator} failed to add {$array['meds_name']} to Medication table");
        $error = "{$array['meds_name']} failed to add to Database";
        array_push($this->e_log, $error);
        return false;
      }
    }
  } //end insert_ass_user

  function admin_insert_medication($array)
  {
    $careObj = new caregiver($array['pcd_id']);
    $email_name_creator = $careObj->data['pcd_email'];
    if ($this->isMedsExist(@$array['meds_name'], @$array['pcd_id'])) { //for validation
      $this->log_class->capture_event_log("Admin failed to add {$array['meds_name']} to Medication table");
      array_push($this->e_log, "Medication existed already, please enter different medication name");
      return false;
    } else {
      $sql = "INSERT INTO `medication` SET  meds_name ='" . @$array['meds_name'] . "',
                                        meds_desc='" . $this->dementiabn_db->real_escape_string(@$array['meds_desc']) . "',
                                        meds_added_date	='" . servDate() . "',
                                        pcd_id='" . @$array['pcd_id'] . "'";
      $insert = $this->dementiabn_db->query($sql);
      if ($insert) {
        $this->log_class->capture_event_log("Admin successfully add {$array['meds_name']} to Medication table on behalf of {$email_name_creator}");
        return true;
      } else {
        $this->log_class->capture_event_log("Admin failed to add {$array['meds_name']} to Medication table");
        $error = "{$array['meds_name']} failed to add to Database";
        array_push($this->e_log, $error);
        return false;
      }
    }
  } //end insert_ass_user



  function isMedsExist($meds_name, $pcd_id)
  {
    $sql = "SELECT * FROM `medication` WHERE `meds_name` = '" . $meds_name . "' AND `pcd_id` = '" . $pcd_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {

      return false;
    }
  }
  function validated_admin_update_medication($array)
  {
    $meds_id = $array['meds_id'];
    $medsObj = new medication($meds_id);
    $db_pcd_id = $medsObj->data['pcd_id'];
    $post_pcd_id = $array['pcd_id'];

    if ($db_pcd_id != $post_pcd_id) { //if medication edited under different caregiver ID
      if ($this->isMedsExist($array['meds_name'], $post_pcd_id)) { //check medication yg kana edit atu exist ka nda sudah. if exist == true, return error
        $this->log_class->capture_event_log("Admin failed to add {$array['meds_name']} to Medication table");
        array_push($this->e_log, "Medication existed already, please enter different medication name");
        return false;
      } else {
        if ($this->admin_update_medication($array)) {
          return true;
        } else {
          return false;
        }
      }
    } else {
      if ($this->admin_update_medication($array)) {
        return true;
      } else {
        return false;
      }
    }
  }
  function admin_update_medication($array)
  {
    $sql = "UPDATE `medication` SET  `meds_name` ='" . @$array['meds_name'] . "',
    `pcd_id` = '" . @$array['pcd_id'] . "',
    `meds_desc` = '" . @$array['meds_desc'] . "' WHERE `meds_id`  ='" . @$array['meds_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      $this->log_class->capture_event_log("Admin successfully update Medicaiton ID:{$array['meds_id']}");
      return true;
    } else {
      $this->log_class->capture_event_log("Admin failed to update Medication ID:{$array['meds_id']}");
      $error = "{$array['meds_id']} failed to update in DB";
      array_push($this->e_log, $error);
      return false;
    }
  }
  function update_medication($array)
  {
    $sql = "UPDATE `medication` SET  `meds_name` ='" . @$array['meds_name'] . "',
                              `meds_desc` = '" . @$array['meds_desc'] . "' WHERE `meds_id`  ='" . @$array['meds_id'] . "'";

    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      return true;
    } else {
      $error = "Medication update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }

  function verified_pcd_meds_entry($pcd_id, $meds_id)
  {
    $sql = "SELECT * FROM `medication` WHERE `pcd_id` = '" . $pcd_id . "' AND `meds_id` = '" . $meds_id . "'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  function disabled_edit_meds_btn_verified($pcd_id, $meds_id)
  {
    $result = $this->verified_pcd_meds_entry($pcd_id, $meds_id);
    if ($result != true) {
      return "disabled";
    }
  }

  function mi_btn_check($patList, $medList)
  {
    if (!empty(@$patList) or !empty(@$medList)) {
      return true;
    } else {
      return 'disabled';
    }
  }




  function insert_user_using_edit($array)
  {
    $sql = "UPDATE `user` SET  `u_dept_id` ='" . @$array['u_dept_id'] . "',
                              `u_ind_no` = '" . @$array['u_ind_no'] . "' WHERE `u_email`  = '" . @$array['user_email'] . "";

    $update = $this->dementiabn_db->query($sql);
  }


  function admin_search_meds($meds_name)
  {
    $search_result = array();
    $sql = "SELECT * FROM medication WHERE meds_name LIKE '$meds_name%'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        $careObj = new caregiver($row['pcd_id']);
        $row['pcd_name'] = $careObj->data['pcd_name'];
        array_push($search_result, $row);
      }
      return $search_result;
    } else {
      array_push($this->e_log, "No search found");
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

  function insert_assigned_meds($array)
  {
    $sql = "INSERT INTO `pc_meds` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                       pt_id='" . @$array['pt_id'] . "',
                                       meds_id='" . @$array['meds_id'] . "',
                                       pcm_qty='" . @$array['pcm_qty'] . "',
                                       pcm_unit='" . @$array['pcm_unit'] . "',
                                       pcm_freq='" . @$array['pcm_freq'] . "',
                                       pcm_remark='" . @$array['pcm_remark'] . "',
                                       pcm_date	='" . servDate() . "'";
    $insert = $this->dementiabn_db->query($sql);
    if ($insert) {
      return true;
    } else {
      $error = "Medication update detail failed";
      array_push($this->e_log, $error);
      return false;
    }
  }

  function edit_assigned_meds($array)
  {
    $sql = "UPDATE `pc_meds` SET  `meds_id` ='" . @$array['meds_id'] . "',
                                  `pcm_qty` ='" . @$array['pcm_qty'] . "',
                                  `pcm_unit` ='" . @$array['pcm_unit'] . "',
                                  `pcm_freq` ='" . @$array['pcm_freq'] . "',
                                  `pcm_remark` ='" . @$array['pcm_remark'] . "',
                                  `pcm_date` = '" . servDate() . "' WHERE `pcm_id`  = '" . @$array['pcm_id'] . "'";
    $update = $this->dementiabn_db->query($sql);
    if ($update) {
      return true;
    } else {
      $error = "SQL UPDATE FAILED";
      array_push($this->e_log, $error);
      return false;
    }
  }

  function list_meds_assigned_to_patient($pt_id)
  {
    $sql = "SELECT * FROM `pc_meds` WHERE `pt_id` = '$pt_id'";
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

  function delete_assigned_meds($array)
  {
    $sql =  "DELETE FROM `pc_meds` WHERE `pcm_id` = '" . $array['pcm_id'] . "'";
    $delete = $this->dementiabn_db->query($sql);
    if ($delete) {
      return true;
    } else {
      $error = "SQL Delete FAILED";
      array_push($this->e_log, $error);
      return false;
    }
  }
}//end medication class
