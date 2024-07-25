<?php
class incident
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $log_class = null;
    public $e_log = array();
    public $success = array();

    public function __construct($inc_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($inc_id != null) {
            $this->setData($inc_id);
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

    function setData($inc_id)
    {
        $sql = "SELECT * FROM incident WHERE inc_id='$inc_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }


    function get_inc_title_only($inc_id)
    {
        $sql = "SELECT `inc_title` FROM `incident` WHERE `inc_id` = '" . $inc_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        $row = $run_query->fetch_assoc();
        return $row['meds_name'];
    }

    function get_inc_data($inc_id)
    {
        $sql = "SELECT * FROM `incident` WHERE `inc_id` = '" . $inc_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }

    function admin_list_all_inc()
    {
        $sql = "SELECT * FROM `incident` ORDER BY `incident`.`inc_id` DESC";
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
    function list_all_inc($pcd_email)
    {
        $sql = "SELECT * FROM `incident` WHERE inc_caller = '" . $pcd_email . "' ORDER BY `incident`.`inc_id` DESC";
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

    function admin_list_filtered_inc_by_status($inc_status)
    {
        $list_filtered = array();
        $sql = "SELECT * FROM `incident` WHERE `inc_status` = '" . $inc_status . "' ORDER BY `incident`.`inc_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                array_push($list_filtered, $row);
            }
            return $list_filtered;
        } else {
            return false;
        }
    }

    function list_filtered_inc_by_status($inc_status, $pcd_email)
    {
        $list_filtered = array();
        $sql = "SELECT * FROM `incident` WHERE `inc_status` = '" . $inc_status . "' AND inc_caller = '" . $pcd_email . "' ORDER BY `incident`.`inc_id` DESC";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            while ($row = $run_query->fetch_assoc()) {
                array_push($list_filtered, $row);
            }
            return $list_filtered;
        } else {
            return false;
        }
    }

    function admin_table_inc_filtered_list($list)
    {
?>
        <div class="table-responsive-sm">
            <table class=table>
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Caller</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (!empty($list)) {
                        foreach ($list as $value) {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $value['inc_title']; ?></td>
                                <td><?php echo $value['inc_status']; ?></td>
                                <td><?php echo get_email_prefix($value['inc_caller']); ?></td>
                                <td> <a href="admin_incident_edit.php?inc_id=<?php echo $value['inc_id'] ?>" class="btn btn-outline-info"> <i class="fas fa-edit"></i></a></td>

                            </tr>
                        <?php
                            $no++;
                        }
                    } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            No incident recorded yet!
                        </div>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }

    function table_inc_filtered_list($list)
    {
    ?>
        <div class="table-responsive-sm">
            <table class=table>
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (!empty($list)) {
                        foreach ($list as $value) {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $value['inc_title']; ?></td>
                                <td><?php echo $value['inc_status']; ?></td>
                                <td> <a href="incident_edit.php?inc_id=<?php echo $value['inc_id'] ?>" class="btn btn-primary"> <i class="fas fa-edit"></i></a></td>

                            </tr>
                        <?php
                            $no++;
                        }
                    } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            No incident recorded yet!
                        </div>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>
<?php
    }
    function sanitize_post_data($post_data)
    {
        $sanitized_data = [];
        foreach ($post_data as $key => $value) {
            $sanitized_data[$key] = $this->dementiabn_db->real_escape_string($value);
        }
        return $sanitized_data;
    }


    function list_inc_by_inc_id($inc_id)
    {
        $sql = "SELECT * FROM `incident` WHERE `inc_id` = '" . $inc_id . "'";
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

    function insert_incident($array)
    {
        $email_name_creator = $_SESSION['pcd_email'];

        $sql = "INSERT INTO `incident` SET  inc_title ='" . @$array['inc_title'] . "',
                                        it_id='" . @$array['it_id'] . "',
                                        inc_desc='" . @$array['inc_desc'] . "',
                                        inc_status ='" . @$array['inc_status'] . "',
                                        inc_caller='" . @$array['inc_caller'] . "',
                                        inc_date_opened='" . @servDate() . "',
                                        inc_date_closed	=''";
        $insert = $this->dementiabn_db->query($sql);
        $inc_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
        if ($insert) {
            $this->log_class->capture_event_log("insert_incident:return 0");
            $this->log_class->capture_event_log("{$email_name_creator} added new incident. Inc ID:{$inc_id}");
            return true;
        } else {
            $this->log_class->capture_event_log("{$email_name_creator} failed to add new incident to DB ");
            $error = "Failed to add New Incident. Kindly email this case to dementiabn@dementiabn.xyz";
            array_push($this->e_log, $error);
            return false;
        }
    } //end insert_ass_user

    function admin_insert_incident($array)
    {
        $email_name_creator = "Admin";
        $pcd_email = $array['pcd_name'];
        $sql = "INSERT INTO `incident` SET  inc_title ='" . @$array['inc_title'] . "',
                                        inc_desc='" . @$array['inc_desc'] . "',
                                         it_id='" . @$array['it_id'] . "',
                                        inc_status ='" . @$array['inc_status'] . "',
                                        inc_caller='" . @$pcd_email . "',
                                        inc_date_opened='" . @servDate() . "',
                                        inc_date_closed	=''";
        $insert = $this->dementiabn_db->query($sql);
        $inc_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
        if ($insert) {
            $this->log_class->capture_event_log("{$email_name_creator} added new incident. Inc ID:{$inc_id}");
            return true;
        } else {
            $this->log_class->capture_event_log("{$email_name_creator} failed to add new incident. ");
            return false;
        }
    } //end insert_ass_user

    function public_insert_incident($array)
    {
        $email_name_creator = "Admin";
        $sql = "INSERT INTO `incident` SET  inc_title ='" . @$array['inc_title'] . "',
                                         it_id='" . @$array['it_id'] . "',
                                        inc_desc='" . @$array['inc_desc'] . "',
                                        inc_status ='" . @$array['inc_status'] . "',
                                        inc_caller='" . @$array['inc_caller'] . "',
                                        inc_date_opened='" . @servDate() . "',
                                        inc_date_closed	=''";
        $insert = $this->dementiabn_db->query($sql);
        $inc_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
        if ($insert) {
            $this->log_class->capture_event_log("{$email_name_creator} added new incident. Inc ID:{$inc_id}");
            return $inc_id;
        } else {
            $this->log_class->capture_event_log("{$email_name_creator} failed to add new incident. ");
            return false;
        }
    } //end insert_ass_user





    function admin_update_incident($array)
    {
        $email_name_creator = "Admin";
        $array = $this->admin_check_inc_datetime($array);
        // Ensure all input values are properly escaped
        $it_id = $this->dementiabn_db->real_escape_string($array['it_id']);
        $inc_title = $this->dementiabn_db->real_escape_string($array['inc_title']);
        $inc_desc = $this->dementiabn_db->real_escape_string($array['inc_desc']);
        $inc_status = $this->dementiabn_db->real_escape_string($array['inc_status']);
        $inc_caller = $this->dementiabn_db->real_escape_string($array['inc_caller']);
        $inc_date_opened = $this->dementiabn_db->real_escape_string($array['inc_date_opened']);
        $inc_date_closed = $array['inc_date_closed'] ? "'" . $this->dementiabn_db->real_escape_string($array['inc_date_closed']) . "'" : 'NULL';
        $inc_id = $this->dementiabn_db->real_escape_string($array['inc_id']);


        $sql = "UPDATE `incident` SET 
        `it_id` = '$it_id',
        `inc_title` = '$inc_title',
        `inc_desc` = '$inc_desc',
        `inc_status` = '$inc_status',
        `inc_caller` = '$inc_caller',
        `inc_date_opened` = '$inc_date_opened',
        `inc_date_closed` = $inc_date_closed 
        WHERE `inc_id` = '$inc_id'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("update_incident:return 0");
            $this->log_class->capture_event_log("{$email_name_creator} successfully update INC ID:{$array['inc_id']}");
            return true;
        } else {
            $this->log_class->capture_event_log("update_incident:return 1");
            $error = "incident update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function admin_check_inc_datetime($array)
    {
        $currentInc = new incident($array['inc_id']);

        if ($array['inc_status'] == "In-Progress") {
            if (!is_datetime_not_set(@$array['inc_date_closed'])) { //if resolved time is set, that mean this incident got reopened else, not set
                $array['inc_date_closed'] = null; // Reset inc_date_closed if it's already set
                $array['inc_date_opened'] = servDate();
            } elseif ($array['inc_date_opened'] == $currentInc->data['inc_date_opened']) {
                $array['inc_date_closed'] = null; // Set inc_date_closed to null
            } elseif ($array['inc_date_opened'] > $currentInc->data['inc_date_opened']) {
                $array['inc_date_closed'] = null; // Reset inc_date_closed if it's already set
            }
        }

        if ($array['inc_status'] == "Resolved") {
            $array['inc_date_closed'] = servDate(); // Reset inc_date_closed if it's already set
        }
        return $array;
    }


    function admin_resolved_incident($array)
    {
        $email_name_creator = "Admin";
        $sql = "UPDATE `incident` SET  `inc_date_closed` = '" . servDate() . "'  WHERE `inc_id`  ='" . @$array['inc_id'] . "'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("admin_resolved_incident:return 0");
            $this->log_class->capture_event_log("{$email_name_creator} successfully resolved INC ID:{$array['inc_id']}");
            return true;
        } else {
            $this->log_class->capture_event_log("admin_resolved_incident:return 1");
            $error = "incident closed failed";
            array_push($this->e_log, $error);
            return false;
        }
    }
    function update_incident($array)
    {
        $email_name_creator = $array['inc_caller'];
        $sql = "UPDATE `incident` SET  `inc_title` ='" . @$array['inc_title'] . "',
                                        `inc_desc` = '" . $array['inc_desc'] . "',
                                        `it_id` = '" . $array['it_id'] . "',
                                        `inc_status` = '" . $array['inc_status'] . "',
                                        `inc_date_closed` = '" . servDate() . "'  WHERE `inc_id`  ='" . @$array['inc_id'] . "'";

        $update = $this->dementiabn_db->query($sql);
        if ($update) {
            $this->log_class->capture_event_log("update_incident:return 0");
            $this->log_class->capture_event_log("{$email_name_creator} successfully update INC ID:{$array['inc_id']}");
            return true;
        } else {
            $this->log_class->capture_event_log("update_incident:return 1");
            $error = "incident update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function verified_pcd_meds_entry($pcd_id, $inc_id)
    {
        $sql = "SELECT * FROM `incident` WHERE `pcd_id` = '" . $pcd_id . "' AND `inc_id` = '" . $inc_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function disabled_edit_meds_btn_verified($pcd_id, $inc_id)
    {
        $result = $this->verified_pcd_meds_entry($pcd_id, $inc_id);
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
        $sql = "SELECT * FROM incident WHERE meds_name LIKE '$meds_name%'";
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
                                       inc_id='" . @$array['inc_id'] . "',
                                       pcm_qty='" . @$array['pcm_qty'] . "',
                                       pcm_unit='" . @$array['pcm_unit'] . "',
                                       pcm_freq='" . @$array['pcm_freq'] . "',
                                       pcm_remark='" . @$array['pcm_remark'] . "',
                                       pcm_date	='" . servDate() . "'";
        $insert = $this->dementiabn_db->query($sql);
        if ($insert) {
            return true;
        } else {
            $error = "incident update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }

    function edit_assigned_meds($array)
    {
        $sql = "UPDATE `pc_meds` SET  `inc_id` ='" . @$array['inc_id'] . "',
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
}//end incident class
