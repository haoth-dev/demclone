<?php
session_start();
$ipage = true;
$title = "Activity";

// Process
require_once("function/function.php");

$patObj = new patient();

if($_SESSION['pcd_level'] != 'secondary'){
  $patList = $patObj->list_all_patient_by_pcdID($_SESSION['pcd_id']);
}
else{
  $patList = $patObj->list_all_patient_by_pcdID($_SESSION['pcd_assign_id']);
}


// Header
require_once("sub/header.php");


// Content
?>



<div class="container">
  <br>
  <h4>Activity</h4>

  <nav>
    <div class="nav nav-tabs activityPage-nav-tab" id="activityPage-nav-tab" role="tablist">
      <?php
      if (!empty($patList)) {
        $patientTabCounter = 1;
        foreach ($patList as $patient) {
      ?>
          <button class="nav-link activityPage-nav-link" id="activityPage-nav-tab-<?php echo $patientTabCounter; ?>" data-bs-toggle="tab" data-bs-target="#activityPage-nav-<?php echo $patientTabCounter; ?>" type="button" role="tab" aria-controls="activityPage-nav-<?php echo $patientTabCounter; ?>" aria-selected="false"><?php echo $patient['pt_name'] ?></button>
      <?php
          $patientTabCounter++;
        }
      } else {
      ?>
        <div class="alert alert-warning" role="alert">
          No Person of Dementia Added yet
        </div>
      <?php
      }
      ?>
    </div>
  </nav>
  <div class="tab-content" id="activityPage-nav-tabContent">
    <?php
    if (!empty($patList)) {
      $patientContentCounter = 1;
      foreach ($patList as $patient) {
        $actObj = new activity();
        $actList = $actObj->list_all_activity_by_patient_id($patient['pt_id']);
    ?>
        <div class="tab-pane fade" id="activityPage-nav-<?php echo $patientContentCounter; ?>" role="tabpanel" aria-labelledby="activityPage-nav-tab-<?php echo $patientContentCounter; ?>">
          <br>
          <a href="activity_add.php?pt_id=<?php echo $patient['pt_id']; ?>" class="btn btn-primary"> <i class="fas fa-plus"></i> Activity</a>
          <br>
          <?php
          $year = date('Y');
          $month = date('n'); // Numeric representation of a month, without leading zeros
          $currentWeekNumber = date('W') - date('W', strtotime("$year-$month-01")) + 1;
          $numberOfWeeksInMonth = getNumberOfWeeksInMonth($year, $month);
          ?>

          <nav>
            <div class="nav nav-tabs subActivityPage-nav-tab mt-3" id="subActivityPage-nav-tab" role="tablist">
              <?php
              for ($weekTabCounter = 1; $weekTabCounter <= $numberOfWeeksInMonth; $weekTabCounter++) {
              ?>
                <button class="nav-link subActivityPage-nav-link" id="subActivityPage-nav-tab-<?php echo $weekTabCounter; ?>" data-bs-toggle="tab" data-bs-target="#subActivityPage-nav-<?php echo $weekTabCounter; ?>-<?php echo $patientContentCounter; ?>" type="button" role="tab" aria-controls="subActivityPage-nav-<?php echo $weekTabCounter; ?>" aria-selected="false"><?php echo "Week $weekTabCounter"; ?></button>
              <?php
              }
              ?>
            </div>
          </nav>
          <div class="tab-content " id="subActivityPage-nav-tabContent">
            <?php
            for ($weekContentCounter = 1; $weekContentCounter <= $numberOfWeeksInMonth; $weekContentCounter++) {
              $hasActivity = false;
            ?>
              <div class="tab-pane fade" id="subActivityPage-nav-<?php echo $weekContentCounter; ?>-<?php echo $patientContentCounter; ?>" role="tabpanel" aria-labelledby="subActivityPage-nav-tab-<?php echo $weekContentCounter; ?>">
                <?php
                if (!empty($actList)) {
                  foreach (getDaysOfWeekDescending() as $day) {
                    $dayHasActivity = false;
                    foreach ($actList as $activity) {
                      $datetime = $activity['act_datetime'];
                      $activityWeekNumber = getWeekNumber($datetime);
                      $activityDay = date('l', strtotime($datetime));
                      if ($activityWeekNumber == $weekContentCounter && $activityDay == $day) {
                        if (!$dayHasActivity) {
                          echo "<h5>$day</h5>";
                          $dayHasActivity = true;
                        }
                        $actObj->act_card_design2($activity['act_id'], $activity['at_id'], $activity['act_name'], $activity['act_desc'], $datetime);
                        $hasActivity = true;
                      }
                    }
                  }
                }
                if (!$hasActivity) {
                ?>
                  <div class="alert alert-warning mt-3" role="alert">
                    No Activity added yet
                  </div>
                <?php
                }
                ?>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
    <?php
        $patientContentCounter++;
      }
    }
    ?>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php
require_once("sub/footer.php");
?>