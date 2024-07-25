<?php
class missing
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $e_log = array();
    public $log_class = null;
    public $success = array();

    public function __construct($mp_id = null, $inc_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($mp_id != null) {
            $this->setData($mp_id);
        }
        if ($inc_id != null) {
            $this->setDataByIncID($inc_id);
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

    function setData($mp_id)
    {
        $sql = "SELECT * FROM missing_pt WHERE mp_id='$mp_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }
    function setDataByIncID($inc_id)
    {
        $sql = "SELECT * FROM missing_pt WHERE inc_id='$inc_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }

    function get_missing_pt_name_only($mp_id)
    {
        $sql = "SELECT `dt_name` FROM `missing_pt` WHERE `mp_id` = '" . $mp_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        $row = $run_query->fetch_assoc();
        return $row['dt_name'];
    }

    function get_meds_data($mp_id)
    {
        $sql = "SELECT * FROM `missing_pt` WHERE `mp_id` = '" . $mp_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_missing_pt()
    {
        $sql = "SELECT * FROM `missing_pt` ORDER BY `missing_pt`.`mp_id` DESC";
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




    function insert_missing_pt($array)
    {
        $ptObj = new patient($array['pt_id']);
        $careObj = new caregiver($ptObj->data['pcd_id']);
        $PWD_name = $ptObj->data['pt_name'];
        $reporter_name = $array['mp_reporter_name'];
        $reported_contact_no = $array['mp_reporter_contact_no'];
        $sql = "INSERT INTO `missing_pt` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_reporter_name ='" . @$array['mp_reporter_name'] . "',
                                                mp_reporter_contact_no ='" . @$array['mp_reporter_contact_no'] . "',
                                                mp_reporter_email ='" . @$array['mp_reporter_email'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        $insertMissingPT = $this->dementiabn_db->query($sql);
        $mp_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
        if ($insertMissingPT) {
            $incObj = new incident();
            $incArray = array();
            $incArray['it_id'] = "2";
            $incArray['inc_title'] = "Missing PWD. Name:{$PWD_name}";
            $incArray['inc_desc'] = " - This is auto generated ticket. A person name:{ $reporter_name} spotted your Person of Dementia. Admin, please contact this person to confirmed:{$reported_contact_no}. ";
            $incArray['inc_status'] = "New";
            $incArray['inc_caller'] = $careObj->data['pcd_email'];
            $result = $incObj->public_insert_incident($incArray);

            if ($result > 0) {
                $inc_id =  $result; //get recently added for scd_id
                $this->log_class->capture_event_log("Dementiabn generated ticket for Missing Person:{$PWD_name}. Incident Ticket:{$inc_id}");

                //update missing table inc_id
                $this->update_missingpt_table($inc_id, $mp_id);
            }
            //add incident and system will assigned to user as new 
            //update missing table with inc id. 
            $this->log_class->capture_event_log("Dementiabn  received missing person.Case ID:{$mp_id}");
            return true;
        } else {
            $error = "Error saving missing PWD to Database";
            array_push($this->e_log, $error);
            return false;
        }
    } //end insert_ass_user

    function update_missingpt_table($inc_id, $mp_id)
    {
        $email_name_creator = "Admin";
        $inc_id = $this->dementiabn_db->real_escape_string($inc_id);
        $mp_id = $this->dementiabn_db->real_escape_string($mp_id);


        $sql = "UPDATE `missing_pt` SET 
        `inc_id` = '$inc_id'
        WHERE `mp_id` = '$mp_id'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("update_missingpt_table:return 0");
            $this->log_class->capture_event_log("{$email_name_creator} successfully update missing PT table: mp_id :{$mp_id}");
            return true;
        } else {
            $this->log_class->capture_event_log("update_missingpt_table:return 1");
            $error = "Missing PT table unable to update. ";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function insert_missing_pt_sql($array)
    {
        $sql = "INSERT INTO `missing_pt` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        return $sql;
    }

    function update_inc_status($array)
    {
        if ($_SESSION['level'] == 'admin') {
            $user = 'Admin';
        } else {

            $user = $_SESSION['pcd_name'];
        }
        $sql = "UPDATE `missing_pt` SET  `mp_status` ='" . @$array['mp_status'] . "' WHERE `mp_id`  ='" . @$array['mp_id'] . "'";
        $mp_status = $array['mp_status'];
        $mp_id = $array['mp_id'];
        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("{$user} update Missing Case ID:{$mp_id} to:{$mp_status}");
            return true;
        } else {
            $this->log_class->capture_event_log("{$user} Failed to update Missing Case ID:{$mp_id}");
            $error = " update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }
} //end missing_pt class
