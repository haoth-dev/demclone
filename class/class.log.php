<?php
class log
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $e_log = array();
    public $success = array();

    public function __construct($al_id = null)
    {
        $this->connect();
        if ($al_id != null) {
            $this->setData($al_id);
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

    function setData($al_id)
    {
        $sql = "SELECT * FROM admin_log WHERE al_id='$al_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }



    function get_log_data($al_id)
    {
        $sql = "SELECT * FROM `admin_log` WHERE `al_id` = '" . $al_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_admin_log()
    {
        $sql = "SELECT * FROM `admin_log` ORDER BY `admin_log`.`al_id` DESC";
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

    function list_access_log()
    {
        $access_log_array = array();
        $sql = "SELECT * FROM `admin_log` WHERE `al_type` = 'access' ORDER BY `admin_log`.`al_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                array_push($access_log_array, $row);
            }
            return  $access_log_array;
        } else {
            return false;
        }
    }

    function list_web_act_log()
    {
        $act_log_array = array();
        $sql = "SELECT * FROM `admin_log` WHERE `al_type` = 'event' ORDER BY `admin_log`.`al_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                array_push($act_log_array, $row);
            }
            return $act_log_array;
        } else {
            return false;
        }
    }




    function insert_admin_log($array)
    {
        $sql = "INSERT INTO `admin_log` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                al_type ='" . @$array['al_type'] . "',
                                                al_detail ='" . $this->dementiabn_db->real_escape_string($array['al_detail']) . "',
                                                al_date ='" .  servDate() . "'";
        $result = $this->dementiabn_db->query($sql);

        if ($result) {
            return true;
        } else {
            $error = "Error saving logs to Database";
            array_push($this->e_log, $error);
            return false;
        }
    } //end insert_ass_user

    function capture_access_log($string)
    {
        $array = array();
        $array['al_type'] = 'access';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_admin_log($array);
    }

    function capture_event_log($string)
    {
        $array = array();
        $array['al_type'] = 'event';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_admin_log($array);
    }




    function insert_admin_log_sql($array)
    {
        $sql = "INSERT INTO `admin_log` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_status ='spotted',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        return $sql;
    }

    function clear_admin_log()
    {
        $sql = "DELETE FROM activity_log";
        $result = $this->dementiabn_db->query($sql);

        if ($result) {
            return true;
        } else {
            $error = "Error saving logs to Database";
            array_push($this->e_log, $error);
            return false;
        }
    }

    //pagination
    function get_paginated_logs($logObj, $page_param, $list_method, $count_method, $items_per_page)
    {
        $page = isset($_GET[$page_param]) ? intval($_GET[$page_param]) : 1;
        $offset = ($page - 1) * $items_per_page;

        // Fetch logs with limit and offset
        $logs = $logObj->$list_method($offset, $items_per_page);
        $totalLogs = $logObj->$count_method();
        $totalPages = ceil($totalLogs / $items_per_page);

        return [
            'logs' => $logs,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    public function list_admin_log_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "SELECT * FROM admin_log ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }

    public function count_all_admin_log()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM admin_log";
            $result = $this->dementiabn_db->query($query);
            if (!$result) {
                throw new Exception("Failed to execute query: " . $this->dementiabn_db->error);
            }
            $row = $result->fetch_assoc();
            return $row['count'];
        } catch (Exception $e) {
            // Log the error message and return 0 as a fallback
            error_log("Database query error: " . $e->getMessage());
            return 0;
        }
    }



    public function list_access_log_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "  SELECT * FROM admin_log WHERE al_type = 'access' ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }
    public function count_access_log()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM admin_log WHERE al_type = 'access'";
            $result = $this->dementiabn_db->query($query);
            if (!$result) {
                throw new Exception("Failed to execute query: " . $this->dementiabn_db->error);
            }
            $row = $result->fetch_assoc();
            return $row['count'];
        } catch (Exception $e) {
            // Log the error message and return 0 as a fallback
            error_log("Database query error: " . $e->getMessage());
            return 0;
        }
    }

    public function list_event_log_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "  SELECT * FROM admin_log WHERE al_type = 'event' ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }

    public function count_event_log()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM admin_log WHERE al_type = 'event'";
            $result = $this->dementiabn_db->query($query);
            if (!$result) {
                throw new Exception("Failed to execute query: " . $this->dementiabn_db->error);
            }
            $row = $result->fetch_assoc();
            return $row['count'];
        } catch (Exception $e) {
            // Log the error message and return 0 as a fallback
            error_log("Database query error: " . $e->getMessage());
            return 0;
        }
    }
} //end admin_log class
