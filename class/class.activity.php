<?php
class activity
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $log_class = null;
    public $e_log = array();
    public $success = array();

    public function __construct($act_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($act_id != null) {
            $this->setData($act_id);
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

    function setData($act_id)
    {
        $sql = "SELECT * FROM activity WHERE act_id='$act_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }



    function get_log_data($act_id)
    {
        $sql = "SELECT * FROM `activity` WHERE `act_id` = '" . $act_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_activity()
    {
        $sql = "SELECT * FROM `activity` ORDER BY `activity`.`act_id` DESC";
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

    function list_all_activity_by_patient_id($pt_id)
    {
        $act_list = array();
        $sql = "SELECT * FROM `activity` WHERE `pt_id` = '" . $pt_id . "' ORDER BY `activity`.`act_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                array_push($act_list, $row);
            }
            return $act_list;
        } else {
            return false;
        }
    } //end list_all_asset_cat()

    function list_access_log()
    {
        $access_log_array = array();
        $sql = "SELECT * FROM `activity` WHERE `al_type` = 'access' ORDER BY `activity`.`act_id` DESC";
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
        $sql = "SELECT * FROM `activity` WHERE `al_type` = 'event' ORDER BY `activity`.`act_id` DESC";
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




    function insert_activity($array)
    {
        $sql = "INSERT INTO `activity` SET  `at_id` ='" . @$array['at_id'] . "',
                                                pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                act_name ='" . @$array['act_name'] . "',
                                                act_desc ='" . @$array['act_desc'] . "',
                                                act_datetime ='" . @$array['act_datetime'] . "'";
        $result = $this->dementiabn_db->query($sql);

        if ($result) {
            return true;
        } else {
            $error = "Error saving logs to Database";
            array_push($this->e_log, $error);
            return false;
        }
    } //end insert_ass_user
    function act_card_design($act_id, $at_id, $act_name, $act_desc, $act_datetime)
    {
        $atObj = new actype($at_id);
        $icon_path = $atObj->data['at_icon_path'];
?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card h-100 mt-3">
                    <div class="card-body">
                        <img src="<?php echo $icon_path; ?>" alt="Activity Icon" class="card-icon">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title"><?php echo $act_name; ?></h5>
                                <p class="card-text"><?php echo $act_desc; ?>
                                    <br>
                                    <small class="text-body-secondary"><?php echo recent($act_datetime); ?></small>
                                </p>
                            </div>
                        </div>
                        <a href="activity_detail.php?act_id=<?php echo $act_id; ?>" class="btn btn-primary"><i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php

    }
    function act_card_design2($act_id, $at_id, $act_name, $act_desc, $act_datetime)
    {
        $atObj = new actype($at_id);
        $icon_path = $atObj->data['at_icon_path'];
        $comObj = new comment();
        $comment_count_no = $comObj->count_act_comment($act_id, 'activity');
    ?>
    <div class="activity-card">
        <div class="activity-card-icon">
            <img src="<?php echo $icon_path; ?>" alt="Activity Icon" class="activity-icon">
        </div>
        <div class="activity-card-details">
            <h5 class="activity-title"><?php echo $act_name; ?> @ <?php echo formatTo12HourClock($act_datetime); ?></h5>
            <p class="activity-description"><?php echo $act_desc; ?>
                <br>
                <small class="activity-time"><?php echo recent($act_datetime); ?></small>
                <br>
                <?php 
                    if($comment_count_no > 0){
                        ?>
                         <small class="activity-comment-number"><?php echo $comment_count_no; ?> comment(s)</small>
                        <?php
                    }
                ?>
              
            </p>
        </div>
        <div class="activity-card-link">
            <a href="activity_detail.php?act_id=<?php echo $act_id; ?>" class="btn btn-primary"><i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
<?php
    }

    function act_card_design3($act_id, $at_id, $act_name, $act_desc, $act_datetime)
    {
        $atObj = new actype($at_id);
        $icon_path = $atObj->data['at_icon_path'];
    ?>
    <div class="activity-card">
        <div class="activity-card-icon">
            <img src="<?php echo $icon_path; ?>" alt="Activity Icon" class="activity-icon">
        </div>
        <div class="activity-card-details">
            <h5 class="activity-title"><?php echo $act_name; ?> @ <?php echo formatTo12HourClock($act_datetime); ?></h5>
            <p class="activity-description"><?php echo $act_desc; ?>
                <br>
                <small class="activity-time"><?php echo recent($act_datetime); ?></small>
            </p>
        </div>
        <div class="activity-card-link">
            <a href="activity_edit.php?act_id=<?php echo $act_id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
        </div>
    </div>
<?php
    }
    function capture_access_log($string)
    {
        $array = array();
        $array['al_type'] = 'access';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_activity($array);
    }

    function capture_event_log($string)
    {
        $array = array();
        $array['al_type'] = 'event';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_activity($array);
    }




    function insert_activity_sql($array)
    {
        $sql = "INSERT INTO `activity` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_status ='spotted',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        return $sql;
    }
    function update_activity_details($array)
    {
        $act_id = $array['act_id'];
        $email_name = get_email_prefix($_SESSION['pcd_email']);
        $sql = "UPDATE `activity` SET  
        `at_id` ='" . $array['at_id'] . "',
        `act_datetime` = '" . $array['act_datetime'] . "',
        `act_name` = '" . $array['act_name'] . "',
        `act_desc` = '" . $array['act_desc'] . "'  WHERE `act_id`  = '" . $array['act_id'] . "'";
        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("{$email_name} succesfully updated act_id:{$act_id} details");
            return true;
        } else {
            $this->log_class->capture_event_log("{$email_name} failed to update act_id:{$act_id} details");
            $err = "Failed update activity details";
            array_push($this->e_log, $err);
            return false;
        }
    }

    function clear_activity()
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

    public function list_activity_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "SELECT * FROM activity ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }

    public function count_all_activity()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM activity";
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
        $query = "  SELECT * FROM activity WHERE al_type = 'access' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM activity WHERE al_type = 'access'";
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
        $query = "  SELECT * FROM activity WHERE al_type = 'event' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM activity WHERE al_type = 'event'";
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
} //end activity class
