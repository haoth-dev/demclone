<?php
class actype
{
    public $dementiabn_db = null;
    public $list = array();
    public $data = null; //for returning variable
    public $e_log = array();
    public $log_class = null;
    public $success = array();

    public function __construct($at_id = null)
    {
        $this->connect();
        $this->log_class = new log();
        if ($at_id != null) {
            $this->setData($at_id);
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

    function setData($at_id)
    {
        $sql = "SELECT * FROM actype WHERE at_id='$at_id'";
        $run_query = $this->dementiabn_db->query($sql);
        $this->data = $run_query->fetch_assoc();
    }



    function get_log_data($at_id)
    {
        $sql = "SELECT * FROM `actype` WHERE `at_id` = '" . $at_id . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            $row = $run_query->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    function list_all_actype()
    {
        $sql = "SELECT * FROM `actype` ORDER BY `actype`.`at_name` ASC";
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
        $sql = "SELECT * FROM `actype` WHERE `al_type` = 'access' ORDER BY `actype`.`at_id` DESC";
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
        $sql = "SELECT * FROM `actype` WHERE `al_type` = 'event' ORDER BY `actype`.`at_id` DESC";
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




    function insert_actype($array)
    {
        if ($this->acTypeValidation($array['at_name'])) {
            $error = "Activiity Name taken, please choose another one";
            array_push($this->e_log, $error);
            return false;
        } else {
            $sql = "INSERT INTO `actype` SET  `at_name` ='" . @$array['at_name'] . "',
                                                `at_desc` ='" . @$array['at_desc'] . "',
                                                `at_icon_path` =''";
            $result = $this->dementiabn_db->query($sql);
            $at_id =  $this->dementiabn_db->insert_id; //get recently added for scd_id
            $folderPath = "asset/icon/";
            $photoId =  $at_id;
            if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
                //delete photo
                $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
                //add new photo
                if ($isPhotoDeleted) {
                    $at_icon_path =  $this->actype_upload_icon($photoId);
                }
                //update data
            } else { //if photo not exist
                //add new photo
                $at_icon_path = $this->actype_upload_icon($photoId);
            }
            $update_icon = $this->update_icon_path_field($photoId, $at_icon_path);
            if ($result) {
                return true;
            } else {
                $error = "Error saving icon to Database";
                array_push($this->e_log, $error);
                return false;
            }
        }
    } //end insert_ass_user

    function acTypeValidation($at_name)
    {
        if ($this->isAcTypeExist($at_name)) {
            $this->log_class->capture_event_log("duplication activity type triggered. please choose another name");
            return true;
        } else {
            return false;
        }
    }

    function isAcTypeExist($at_name)
    {
        $sql = "SELECT * FROM `actype` WHERE `at_name` = '" . $at_name . "'";
        $run_query = $this->dementiabn_db->query($sql);
        if ($run_query->num_rows > 0) {
            return  true;
        } else {
            return false;
        }
    }

    function actype_upload_icon($photo_name)
    {
        // Directory where the file will be saved
        $targetDir = "asset/icon/";

        // Get the new file name from the input
        $newFileName = $photo_name;
        $imageFileType = strtolower(pathinfo($_FILES["icon_image"]["name"], PATHINFO_EXTENSION));
        $newFileNameWithExtension = $newFileName . '.' . $imageFileType;
        $targetFile = $targetDir . $newFileNameWithExtension;
        $uploadOk = 1;

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["icon_image"]["tmp_name"]);
        if ($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            $err =  "File is not an image.<br>";
            array_push($this->e_log, $err);
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {

            $err =  "Sorry, file already exists.<br>";
            array_push($this->e_log, $err);
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["icon_image"]["size"] > 5000000) {
            $err =  "Sorry, your file is too large.<br>";
            array_push($this->e_log, $err);
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            $err =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            array_push($this->e_log, $err);
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $err =  "Sorry, your file was not uploaded.<br>";
            array_push($this->e_log, $err);
        } else {
            // Try to upload file
            if (move_uploaded_file($_FILES["icon_image"]["tmp_name"], $targetFile)) {
                return  $targetFile;
            } else {
                array_push($this->e_log, "Sorry, there was an error uploading your file.<br>");
                return false;
            }
        }
    }

    function update_icon_path_field($at_id, $at_icon_path)
    {
        $sql = "UPDATE `actype` SET  `at_icon_path` ='" . $at_icon_path . "'  WHERE `at_id`  = '" . @$at_id . "'";
        $update = $this->dementiabn_db->query($sql);
        $email_name =  get_email_prefix($_SESSION['pcd_email']);
        if ($update) {
            $this->log_class->capture_event_log("{$email_name} succesfully update icon for at_id:{$at_id}");
            return true;
        } else {
            $this->log_class->capture_event_log("{$email_name} failed to update icon for at_id:{$at_id}");
            $err = "Failed to upload icon";
            array_push($this->e_log, $err);
            return false;
        }
    }

    function update_actype($array)
    {
        $folderPath = "asset/icon/";
        $photoId = $array['at_id'];
        if (scanImagesInFolder($folderPath, $photoId)) { //if photo exist
            //delete photo
            $isPhotoDeleted = deletePhotoInFolder($folderPath, $photoId);
            //add new photo
            if ($isPhotoDeleted) {
                $at_icon_path =  $this->actype_upload_icon($photoId);
            }
            //update data
        } else { //if photo not exist
            //add new photo
            $at_icon_path = $this->actype_upload_icon($photoId);
        }

        $sql = "UPDATE `actype` SET 
        `at_name`='" . @$array['at_name'] . "',
        `at_desc`='" . @$array['at_desc'] . "',
        `at_icon_path`='" .  $at_icon_path  . "'  WHERE 
        `at_id` = '" . @$array['at_id'] . "'";

        $update = $this->dementiabn_db->query($sql);

        $email_name_creator = get_email_prefix($_SESSION['pcd_email']);
        if ($update) {
            $this->log_class->capture_event_log("{$email_name_creator} successfully updated act type id:{$photoId} data");
            return true;
        } else {
            $this->log_class->capture_event_log("{$email_name_creator} failed to  updated act type id:{$photoId} data");
            $error = "User update detail failed";
            array_push($this->e_log, $error);
            return false;
        }
    }



    function capture_access_log($string)
    {
        $array = array();
        $array['al_type'] = 'access';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_actype($array);
    }

    function capture_event_log($string)
    {
        $array = array();
        $array['al_type'] = 'event';
        $array['al_detail'] = $string;
        $array['al_date'] = servDate();
        $array['pcd_id'] = $_SESSION['pcd_id'];

        $this->insert_actype($array);
    }




    function insert_actype_sql($array)
    {
        $sql = "INSERT INTO `actype` SET  pcd_id ='" . @$array['pcd_id'] . "',
                                                pt_id ='" . @$array['pt_id'] . "',
                                                mp_latitude ='" . @$array['mp_latitude'] . "',
                                                mp_longitude ='" . @$array['mp_longitude'] . "',
                                                mp_status ='spotted',
                                                mp_date ='" . servDate() . "',
                                                mp_remark ='" . @$array['mp_remark'] . "'";
        return $sql;
    }

    function clear_actype()
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

    public function list_actype_paginated($offset, $limit)
    {
        // Query to fetch logs with limit and offset
        $query = "SELECT * FROM actype ORDER BY al_date DESC LIMIT ? OFFSET ?";
        $stmt = $this->dementiabn_db->prepare($query);
        $stmt->bind_param('ii', $limit, $offset); //ii -> both parameter are integer
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $logs;
    }

    public function count_all_actype()
    {
        try {
            // Query to count total logs
            $query = "SELECT COUNT(*) as count FROM actype";
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
        $query = "  SELECT * FROM actype WHERE al_type = 'access' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM actype WHERE al_type = 'access'";
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
        $query = "  SELECT * FROM actype WHERE al_type = 'event' ORDER BY al_date DESC LIMIT ? OFFSET ?";
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
            $query = "SELECT COUNT(*) as count FROM actype WHERE al_type = 'event'";
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
} //end actype class
