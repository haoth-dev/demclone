<?php
session_start();
$ipage = true;
$title = "Activity";

// Process
require_once("function/function.php");

$patObj = new patient();
$patList = $patObj->list_all_patient_by_pcdID($_SESSION['pcd_id']);

// Header
require_once("sub/header.php");



// Content
?>

<div class="container">
  <br>
  <h4>Activity</h4>

  <nav>
    <div class="nav nav-tabs activityPage-nav-tab" id="activityPage-nav-tab" role="tablist">
      <?php if (!empty($patList)) : ?>
        <?php foreach ($patList as $index => $patient) : ?>
          <!-- Patient Tab Button -->
          <button class="nav-link activityPage-nav-link" id="activityPage-nav-tab-<?php echo $index + 1; ?>" data-bs-toggle="tab" data-bs-target="#activityPage-nav-<?php echo $index + 1; ?>" type="button" role="tab" aria-controls="activityPage-nav-<?php echo $index + 1; ?>" aria-selected="false"><?php echo htmlspecialchars($patient['pt_name']); ?></button>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="alert alert-warning" role="alert">
          No Person of Dementia Added yet
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <div class="tab-content" id="activityPage-nav-tabContent">
    <?php if (!empty($patList)) : ?>
      <?php foreach ($patList as $index => $patient) : ?>
        <?php
        $actObj = new activity();
        $actList = $actObj->list_all_activity_by_patient_id($patient['pt_id']);
        $year = date('Y');
        $month = date('n'); // Numeric representation of the current month
        $numberOfWeeksInMonth = getNumberOfWeeksInMonth($year, $month);
        ?>
        <!-- Patient Tab Content -->
        <div class="tab-pane fade" id="activityPage-nav-<?php echo $index + 1; ?>" role="tabpanel" aria-labelledby="activityPage-nav-tab-<?php echo $index + 1; ?>">
          <br>
          <a href="activity_add.php?pt_id=<?php echo htmlspecialchars($patient['pt_id']); ?>" class="btn btn-primary"> <i class="fas fa-plus"></i> Activity</a>
          <br>
          <nav>
            <div class="nav nav-tabs subActivityPage-nav-tab mt-3" id="subActivityPage-nav-tab-<?php echo $index + 1; ?>" role="tablist">
              <?php for ($week = 1; $week <= $numberOfWeeksInMonth; $week++) : ?>
                <!-- Week Tab Button -->
                <button class="nav-link subActivityPage-nav-link" id="subActivityPage-nav-tab-<?php echo $index + 1 . '-' . $week; ?>" data-bs-toggle="tab" data-bs-target="#subActivityPage-nav-<?php echo $index + 1 . '-' . $week; ?>" type="button" role="tab" aria-controls="subActivityPage-nav-<?php echo $index + 1 . '-' . $week; ?>" aria-selected="false"><?php echo "Week $week"; ?></button>
              <?php endfor; ?>
            </div>
          </nav>
          <div class="tab-content mt-3" id="subActivityPage-nav-tabContent-<?php echo $index + 1; ?>">
            <?php for ($week = 1; $week <= $numberOfWeeksInMonth; $week++) : ?>
              <!-- Week Tab Content -->
              <div class="tab-pane fade" id="subActivityPage-nav-<?php echo $index + 1 . '-' . $week; ?>" role="tabpanel" aria-labelledby="subActivityPage-nav-tab-<?php echo $index + 1 . '-' . $week; ?>">
                <?php
                $hasActivity = false;
                if (!empty($actList)) {
                  foreach ($actList as $activity) {
                    $datetime = $activity['act_datetime'];
                    $activityWeekNumber = getWeekNumber($datetime);
                    if ($activityWeekNumber == $week) {
                      $actObj->act_card_design($activity['act_id'], $activity['at_id'], $activity['act_name'], $activity['act_desc'], $datetime);
                      $hasActivity = true;
                    }
                  }
                }
                if (!$hasActivity) {
                ?>
                  <div class="alert alert-warning mt-3" role="alert">
                    No Activity added yet
                  </div>
                <?php } ?>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="path/to/your/js/activity.js"></script>

<?php
require_once("sub/footer.php");
?>