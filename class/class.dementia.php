<?php
class dementia
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $e_log = array();
    public $success = array();

    public function __construct($dt_id = null)
    {
        $this->connect();
        if ($dt_id != null) {
            $this->setData($dt_id);
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

    function setData($dt_id)
    {
        $sql = "SELECT * FROM dem_type WHERE dt_id='$dt_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }

    function get_dem_type_name_only($dt_id)
    {
        $sql = "SELECT `dt_name` FROM `dem_type` WHERE `dt_id` = '" . $dt_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        $row = $run_query->fetch_assoc();
        return $row['dt_name'];
    }

    function get_meds_data($dt_id)
    {
        $sql = "SELECT * FROM `dem_type` WHERE `dt_id` = '" . $dt_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_dem_type()
    {
        $sql = "SELECT * FROM `dem_type`";
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
        $sql = "SELECT * FROM `dem_type` WHERE `pcd_id` = '" . $pcd_id . "'";
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

    function insert_dem_type($array)
    {
        if ($this->isDemTypeExist(@$array['dt_name'])) { //for validation
            array_push($this->e_log, "Dementia type existed already, please enter different dementia type name");
            return false;
        } else {
            $sql = "INSERT INTO `dem_type` SET  dt_name ='" . @$array['dt_name'] . "',
                                                dt_desc='" . @$array['dt_desc'] . "'";
            $insert = $this->dementiabn_db->query($sql);
            if ($insert) {
                return true;
            } else {
                echo $sql;
                return false;
            }
        }
    } //end insert_ass_user




    function isDemTypeExist($dt_name)
    {
        $sql = "SELECT * FROM `dem_type` WHERE `dt_name` = '" . $dt_name . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_dem_type($array)
    {
        $sql = "UPDATE `dem_type` SET  `meds_name` ='" . @$array['meds_name'] . "',
                              `meds_desc` = '" . @$array['meds_desc'] . "' WHERE `dt_id`  ='" . @$array['dt_id'] . "'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            return true;
        } else {
            $error = "dem_type update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function clear_dem_type_data()
    {
        $sql = "DELETE FROM dem_type";
        $result = $this->dementiabn_db->query($sql);

        if ($result) {
            return true;
        } else {
            $error = "Error deleting dem_type to Database";
            array_push($this->e_log, $error);
            return false;
        }
    }
}//end dem_type class
