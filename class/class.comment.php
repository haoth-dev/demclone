<?php
class comment
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $e_log = array();
    public $log_class = null;
    public $success = array();

    public function __construct($c_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($c_id != null) {
            $this->setData($c_id);
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

    function setData($c_id)
    {
        $sql = "SELECT * FROM comment WHERE c_id='$c_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }



    function get_comment_data($c_id)
    {
        $sql = "SELECT * FROM `comment` WHERE `c_id` = '" . $c_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_comment()
    {
        $sql = "SELECT * FROM `comment` ORDER BY `comment`.`c_id` DESC";
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

    function list_inc_comment($c_ref_id, $c_task_type)
    {
        $inc_comment_array = array();
        $sql = "SELECT * FROM `comment` WHERE `c_ref_id` = '" . $c_ref_id . "' AND c_task_type = '" . $c_task_type . "' ORDER BY `comment`.`c_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                $careObj = new caregiver($row['c_commentor_id']);
                $duration = recent($row['c_posted_datetime']);
                $pcd_name = $careObj->data['pcd_name'];
                $row['pcd_name'] = $pcd_name;
                $row['duration'] = $duration;
                array_push($inc_comment_array, $row);
            }
            return  $inc_comment_array;
        } else {
            return false;
        }
    }

    function list_act_comment($c_ref_id, $c_task_type)
    {
        $act_comment_array = array();
        $sql = "SELECT * FROM `comment` WHERE `c_ref_id` = '" . $c_ref_id . "' AND c_task_type = '" . $c_task_type . "' ORDER BY `comment`.`c_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                $careObj = new caregiver($row['c_commentor_id']);
                $duration = recent($row['c_posted_datetime']);
                $pcd_name = $careObj->data['pcd_name'];
                $row['pcd_name'] = $pcd_name;
                $row['duration'] = $duration;
                array_push($act_comment_array, $row);
            }
            return  $act_comment_array;
        } else {
            return false;
        }
    }
    function count_act_comment($c_ref_id, $c_task_type)
    {
        $sql = "SELECT COUNT(*) as count FROM `comment` WHERE `c_ref_id` = '" . $c_ref_id . "' AND c_task_type = '" . $c_task_type . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row['count'];
        } else {
            return 0;
        }
    }
    
    

    function list_web_act_log()
    {
        $act_log_array = array();
        $sql = "SELECT * FROM `comment` WHERE `al_type` = 'event' ORDER BY `comment`.`c_id` DESC";
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




    function insert_comment($array)
    {

        $sql = "INSERT INTO `comment` SET  c_commentor_id ='" . @$array['c_commentor_id'] . "',
                                                c_posted_datetime ='" . @$array['c_posted_datetime'] . "',
                                                c_content='" .  $this->dementiabn_db->real_escape_string($array['c_content']) . "',
                                                c_ref_id='" .  @$array['c_ref_id'] . "',
                                                c_task_type='" .  @$array['c_task_type'] . "'";
        $result = $this->dementiabn_db->query($sql);

        if ($result) {
            return true;
        } else {
            $error = "Error saving Comment to Database";
            array_push($this->e_log, $error);
            return false;
        }
    } //end insert_ass_user

    function post_inc_comment($string, $ref_id)
    {
        $array = array();
        $array['c_task_type'] = 'incident';
        $array['c_ref_id'] = $ref_id;
        $array['c_content'] = $string;
        $array['c_posted_datetime'] = servDate();
        $array['c_commentor_id'] = $_SESSION['pcd_id'];

        $result = $this->insert_comment($array);
        return $result;
    }

    function post_act_comment($string, $ref_id)
    {
        $array = array();
        $array['c_task_type'] = 'activity';
        $array['c_ref_id'] = $ref_id;
        $array['c_content'] = $string;
        $array['c_posted_datetime'] = servDate();
        $array['c_commentor_id'] = $_SESSION['pcd_id'];

        $result = $this->insert_comment($array);
        $careObj = new caregiver($_SESSION['pcd_id']);

        $email = $careObj->data['pcd_email'];
        $subject = "Added New comment on Activity ID:{$ref_id}";
        $message = "Comment added on your Activity ID:{$ref_id}";
        $mail = ar_mail2($email,$subject,$message);
        return $result;
    }




    function insert_comment_sql($array)
    {
        $sql = "INSERT INTO `comment` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_status ='spotted',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        return $sql;
    }

    function clear_comment()
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

    public function list_comment_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "SELECT * FROM comment ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }

    public function count_all_comment()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM comment";
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
        $query = "  SELECT * FROM comment WHERE al_type = 'access' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM comment WHERE al_type = 'access'";
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
        $query = "  SELECT * FROM comment WHERE al_type = 'event' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM comment WHERE al_type = 'event'";
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
} //end comment class
