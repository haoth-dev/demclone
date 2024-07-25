<?php
session_start();
$ipage = true;
$title = "Medication";

//process
require_once("function/function.php");
//view_array($_SESSION);
$medsObj = new medication();
$medsList = $medsObj->list_all_meds();
//view_array($medsList);

if(isset($_POST['ajax_detail_btn'])){
  $response = array();
  $medsDetailObj = new medication($_POST['ajax_meds_id']);
  $response['medsData'] = $medsDetailObj->data;
  $response['success'] = true;
  echo json_encode($response);
  exit();
}

//header
require_once("sub/header.php");

//content
?>


  <div class="container">
 
   <h4>Medication</h4>

   <div class="table-responsive-sm">
    <table class=table>
      <thead>
        <th>#</th>
        <th>Name</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if(!empty($medsList)){
          foreach($medsList as $value){
               ?>
                <tr>
                  <td><?php echo $no; ?></td>  
                  <td><?php echo $value['meds_name']; ?></td>
                  <td> <input type="hidden" class="meds_id_val" value="<?php echo $value['meds_id']; ?>">
                  <button class="btn btn-outline-primary" onclick="meds_detail(this)">Detail</button></td>
                </tr>
               <?php
               $no++;
          }
        }
        else{

        }
          
        ?>
      </tbody>

    </table>
    </div>

    <!-- Detail Meds Modal -->
<div class="modal fade" id="medsDetailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Medication Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div id="view_meds_data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick=meds_update_form()>Update Meds</button>
      </div>
    </div>
  </div>
</div>





 
   <br>
   <a href="medication_add.php" class="btn btn-primary floating-button">
    <i class="fas fa-plus"></i>
  </a>


  </div>

<?php

require_once("sub/footer.php");
?>

<script>
  function meds_detail(button) {
    var meds_id = $(button).siblings('.meds_id_val').val();
    // console.log(meds_id);
    $.ajax({
        url: 'medication.php',//antar ke mana
        method: 'POST',//apa methodnya
        dataType: 'json',//apa data typenya
        data: {
            'ajax_detail_btn': 1,//untuk isset rh php
            'ajax_meds_id': meds_id
        },
        success: function (array) {//kalau ajax success ngantar

            loadMedsModal(array);

            // console.log(array.medsData);
        },
        error: function (array) {
            console.log("failed");
        }
    });
}

function loadMedsModal(array) {
    // $('#view_meds_data').html(array);
    var div_list_user = document.getElementById('view_meds_data');
    var content = "";
    content += "";


    content += "<div class='card'>"
        + "  <div class='card-body'>"
        + " <h5 class='card-title'>" + array.medsData['meds_name'] + "</h5>"
        + " <p class='card-text'>" + array.medsData['meds_desc'] + "</p>"
        + " </div>"
        + "</div>"


    div_list_user.innerHTML = content;
    $('#medsDetailModal').modal('show');
}

function meds_update_form() {
    alert("test");
}
</script>

<?php
class medication{
  public $dementiabn_db = null;
  public $list = array();
  public $data = null; //for returning variable
  public $e_log = array();
  public $success = array();

  public function __construct($meds_id = null){
      $this->connect();
      if ($meds_id != null) {
        $this->setData($meds_id);
      }
  }

  function connect(){
    $this->dementiabn_db = new mysqli(url,username,password,name);//$db is an objet, create form mysqli class..
  }

  function check_db_connect(){
    
   $connect = $this->dementiabn_db = new mysqli(url,username,password,name);//$db is an objet, create form mysqli class..
   return $connect->connect_errno;
    
  }

  function setData($meds_id){
    $sql = "SELECT * FROM medication WHERE meds_id='$meds_id'";
    $run_query = $this->dementiabn_db->query($sql);
    $this->data = $run_query->fetch_assoc();
  }

  function get_user_data($meds_id){
    $sql = "SELECT * FROM `medication` WHERE `meds_id` = '".$meds_id."'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
    $row = $run_query->fetch_assoc();
        return $row;
    }
    else {
      return false;
    }
  }
  function list_all_meds(){
    $sql = "SELECT * FROM `medication`";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($this->list,$row);
      }
      return $this->list;
    }
    else{
      return false;
    }
  }//end list_all_asset_cat()


  function list_meds_by_pcd($pcd_id){
    $sql = "SELECT * FROM `medication` WHERE `pcd_id` = '".$pcd_id."'";
    $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
      while ($row = $run_query->fetch_assoc()) {
        array_push($this->list,$row);
      }
      return $this->list;
    }
    else{
      return false;
    }
  }//end list_all_asset_cat()

function insert_medication($array){
    if ($this->isMedsExist(@$array['meds_name'])) {//for validation
      array_push($this->e_log,"Medication existed already, please enter different medication name");
    return false;
    }
    else{
      $sql = "INSERT INTO `medication` SET  meds_name ='".@$array['meds_name']."',
                                        meds_desc='".@$array['meds_desc']."',
                                        meds_added_date	='".servDate()."',
                                        pcd_id='".@$_SESSION['pcd_id']."'";
       $insert = $this->dementiabn_db->query($sql);
       if ($insert) {
         return true;
       }
       else{
         echo $sql;
         return false;
       }

    }
}//end insert_ass_user


function isMedsExist($meds_name){
  $sql = "SELECT * FROM `medication` WHERE `meds_name` = '".$meds_name."'";
  $run_query = $this->dementiabn_db->query($sql);
    if ($run_query->num_rows > 0) {
        return true;
    }
    else {
      return false;
    }
}




function insert_user_using_edit($array){
  $sql = "UPDATE `user` SET  `u_dept_id` ='".@$array['u_dept_id']."',
                              `u_ind_no` = '".@$array['u_ind_no']."' WHERE `u_email`  = '".@$array['user_email']."";

  $update = $this->dementiabn_db->query($sql);
}

function update_user_data($array){
  $sql = "UPDATE `user` SET  `d_acr` ='".@$array['d_acr']."',
                              `u_ind_no` = '".@$array['u_ind_no']."',
                              `u_title` = '".@$array['u_title']."' WHERE `u_email`  ='".@$array['u_email']."'";

  $update = $this->dementiabn_db->query($sql);
  if ($update) {
     return true;
  }
  else {
    $error= "User update detail failed";
    array_push($this->e_log,$error);
    return false;
  }

}


//user foreign table

function check_task_based_on_u_email($u_email){
  $sql = "SELECT * FROM `task` WHERE `u_email` = '$u_email'";
  $run_query = $this->dementiabn_db->query($sql);
  if ($run_query->num_rows > 0) {
      return true;
  }
  else{
      array_push($this->e_log,"No Asset Assigned to this User yet!!");
  }
}


}





?>
