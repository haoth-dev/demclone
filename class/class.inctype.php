<?php
class inctype
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $log_class = null;
    public $e_log = array();
    public $success = array();

    public function __construct($it_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($it_id != null) {
            $this->setData($it_id);
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

    function setData($it_id)
    {
        $sql = "SELECT * FROM inc_type WHERE it_id='$it_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }


    function get_it_name_only($it_id)
    {
        $sql = "SELECT `inc_title` FROM `inc_type` WHERE `it_id` = '" . $it_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        $row = $run_query->fetch_assoc();
        return $row['meds_name'];
    }

    function get_inc_type_data($it_id)
    {
        $sql = "SELECT * FROM `inc_type` WHERE `it_id` = '" . $it_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_inc_type()
    {
        $sql = "SELECT * FROM `inc_type`";
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


    function list_inc_by_it_id($it_id)
    {
        $sql = "SELECT * FROM `inc_type` WHERE `it_id` = '" . $it_id . "'";
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

    function insert_inc_type($array)
    {
        $email_name_creator = "Admin";
        if ($this->it_type_validation($array['it_name'])) { //should return 0;
            $sql = "INSERT INTO `inc_type` SET  it_name ='" . @$array['inc_title'] . "',
                                                it_desc='" . @$array['inc_desc'] . "'";
            $insert = $this->dementiabn_db->query($sql);
            $it_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
            if ($insert) {
                $this->log_class->capture_event_log("insert_inc_type:return 0");
                $this->log_class->capture_event_log("{$email_name_creator} added new inc_type. inc type ID:{$it_id}");
                return true;
            } else {
                $this->log_class->capture_event_log("{$email_name_creator} failed to add new inc_type to DB.  ");
                return false;
            }
        } else {
            $this->log_class->capture_event_log("Validation failed triggered. please check your log.");
            return false;
        }
    } //end insert_ass_user




    function it_type_validation($it_name)
    {
        if ($this->isIncTypeExist($it_name)) { //if this function return true, ertinya ada duplication, hence return false in statement
            $this->log_class->capture_event_log("{$it_name} existed already, please enter different inc_type name");
            array_push($this->e_log, "{$it_name} existed already, please enter different inc_type name");
            return false;
        } else {
            $this->log_class->capture_event_log("it_type_validation:return 0");
            return true; //validation clear
        }
    }
    function isIncTypeExist($it_name)
    {
        $sql = "SELECT * FROM `inc_type` WHERE `it_name` = '" . $it_name . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            return true; //kalau inc type exist sudah - return false, to prevent data duplication
        } else {
            return false;
        }
    }

    function admin_update_inc_type($array)
    {
        $sql = "UPDATE `inc_type` SET  `meds_name` ='" . @$array['meds_name'] . "',
                                        `pcd_id` = '" . @$array['pcd_id'] . "',
                                        `meds_desc` = '" . @$array['meds_desc'] . "' WHERE `it_id`  ='" . @$array['it_id'] . "'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("Admin successfully update Medicaiton ID:{$array['it_id']}");
            return true;
        } else {
            $this->log_class->capture_event_log("Admin failed to update inc_type ID:{$array['it_id']}");
            $error = "{$array['it_id']} failed to update in DB";
            array_push($this->e_log, $error);
            return false;
        }
    }
    function update_inc_type($array)
    {
        $sql = "UPDATE `inc_type` SET  `meds_name` ='" . @$array['meds_name'] . "',
                              `meds_desc` = '" . @$array['meds_desc'] . "' WHERE `it_id`  ='" . @$array['it_id'] . "'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            return true;
        } else {
            $error = "inc_type update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function verified_pcd_meds_entry($pcd_id, $it_id)
    {
        $sql = "SELECT * FROM `inc_type` WHERE `pcd_id` = '" . $pcd_id . "' AND `it_id` = '" . $it_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function disabled_edit_meds_btn_verified($pcd_id, $it_id)
    {
        $result = $this->verified_pcd_meds_entry($pcd_id, $it_id);
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
        $sql = "SELECT * FROM inc_type WHERE meds_name LIKE '$meds_name%'";
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
                                       it_id='" . @$array['it_id'] . "',
                                       pcm_qty='" . @$array['pcm_qty'] . "',
                                       pcm_unit='" . @$array['pcm_unit'] . "',
                                       pcm_freq='" . @$array['pcm_freq'] . "',
                                       pcm_remark='" . @$array['pcm_remark'] . "',
                                       pcm_date	='" . servDate() . "'";
        $insert = $this->dementiabn_db->query($sql);
        if ($insert) {
            return true;
        } else {
            $error = "inc_type update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function edit_assigned_meds($array)
    {
        $sql = "UPDATE `pc_meds` SET  `it_id` ='" . @$array['it_id'] . "',
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
}//end inc_type class
