<?php

if (!isset($ipage)) header("Location: index");
?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="asset/images/favicon.png" />
  <?php echo stylesheet; ?>
  <?php if ($title == 'Activity detail' || $title == 'Activity') echo activity_css; ?>
  <?php if ($title == 'about us') echo about_us; ?>
  <?php if ($title == 'Guest Register') echo guest_css; ?>
  <?php if ($title == 'DEBUGGING' || $title == 'Admin PWD Activity' || $title == 'Admin Activity Type' || $title == 'Patient' || $title == 'Support' || $title == 'Admin PWD' || $title == 'Admin User Mgmt' || $title == 'Missing PWD details' || $title == 'Admin Edit Incident') echo pwd_profile_card_css; ?>
  <?php echo top_js_script; ?>
</head>

<body>

  <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary ">

    <button class="navbar-toggler mt-4" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="index.php">
        <img src="asset/images/appicon_light.png" width="30" height="30" alt="">
      </a>
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
        </li>

        <?php
        $login = true;

        if (isset($_SESSION['pcd_email'])) {
        ?>



          <?php
          //admin nav bar zone start//////////////////////////////////////////
          if ($_SESSION['pcd_level'] == 'admin') {
          ?>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><i class="fas fa-align-justify"></i></a>
            </li>


          <?php
          }
          ?>

          <?php

          //admin nav bar zone end//////////////////////////////////////////
          if ($_SESSION['pcd_level'] == 'primary') {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="patient.php">People with Dementia</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="support.php">Additonal Support</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="medication.php">Medication</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="medication_intake.php">Meds Intake</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="incident.php">Incident</a>
            </li>


          <?php
          }

          if ($_SESSION['pcd_level'] == 'secondary') {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="patient2.php">People with Dementia</a>
            </li>
          <?php
          }

          ?>

          <?php
          if ($_SESSION['pcd_level'] != 'admin') {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="activity.php">Activity</a>
            </li>

            <li class="nav-item ">
              <a class="nav-link" href="aboutus.php">About Us </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="contactus.php">Contact Us</a>
            </li>

            <form class="form-inline my-2 my-lg-0">

              <a class="btn btn-primary my-2 my-sm-0" href="logout.php">Logout</a>
            </form>
          <?php

          }
          ?>





        <?php
        } else {
        ?>
          <li class="nav-item ">
            <a class="nav-link" href="aboutus.php">About Us </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="contactus.php">Contact Us</a>
          </li>
        <?php
        }
        ?>

      </ul>
    </div>
  </nav>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body ">
      <table class="table table-hover">
        <tr>
          <td class="clickable-td"><a href="admin_user_mgmt.php"><i class="fas fa-user-tie"></i> User</a></td>
        </tr>
        <tr>
          <td>
            <a data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fas fa-wheelchair"></i> People With Dementia
            </a>
            <div class="collapse" id="collapseExample">
              <div class="custom-card">
                <a href="admin_pwd.php" class="dropdown-item"><i class="fas fa-list"></i> List Person with Dementia</a>
                <a href="admin_pwd_add.php" class="dropdown-item"><i class="fas fa-plus"></i> Add Person with Dementia</a>
                <a href="admin_pwd_type.php" class="dropdown-item"><i class="fas fa-list"></i> List Type of Dementia</a>
                <a href="admin_pwd_type_add.php" class="dropdown-item"><i class="fas fa-plus"></i> Add Dementia Type</a>

              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td>
            <a data-bs-toggle="collapse" data-bs-target="#collapseActivity" aria-expanded="false" aria-controls="collapseActivity">
              <i class="fas fa-clipboard-list"></i> Activity
            </a>
            <div class="collapse" id="collapseActivity">
              <div class="custom-card">
                <a href="admin_activity.php" class="dropdown-item"><i class="fas fa-list"></i> List Of Activity Log</a>
                <a href="admin_activity_add.php" class="dropdown-item"><i class="fas fa-plus"></i> Add Activity Log</a>
                <a href="admin_actype.php" class="dropdown-item"><i class="fas fa-list"></i> List Type of Activity</a>
                <a href="admin_actype_add.php" class="dropdown-item"><i class="fas fa-plus"></i> Add Activity Type</a>

              </div>
            </div>
          </td>
        </tr>


        <tr>
          <td>
            <a data-bs-toggle="collapse" data-bs-target="#collapseMedLib" aria-expanded="false" aria-controls="collapseMedLib">
              <i class="fas fa-tablets"></i> Medication
            </a>
            <div class="collapse" id="collapseMedLib">
              <div class="custom-card">
                <a href="admin_medlib.php" class="dropdown-item"><i class="fas fa-list"></i> List of Medication</a>
                <a href="admin_medlib_add.php" class="dropdown-item"><i class="fas fa-plus"></i> Add Medication</a>
                <a href="admin_medlib_search.php" class="dropdown-item"><i class="fas fa-list"></i> Search Medication</a>
              </div>
            </div>
          </td>
        </tr>



        <tr>
          <td class="clickable-td"><a href="admin_incident.php"><i class="fas fa-laptop-medical"></i> Incident </a></td>
        </tr>
        <tr>
          <td class="clickable-td"><a href="missing_pwd.php"><i class="fas fa-street-view"></i> Missing P.W.D </a></td>
        </tr>

        <tr>
          <td class="clickable-td"><a href="admin_report.php"><i class="far fa-clipboard"></i> Report Gen</a></td>
        </tr>

        <tr>
          <td class="clickable-td"><a href="admin_solution.php"><i class="fas fa-table"></i> Solution</a></td>
        </tr>

        <tr>
          <td class="clickable-td"><a href="admin_log.php"><i class="fas fa-tasks"></i> Admin Logs Panel</a></td>
        </tr>

        <tr>
          <td class="clickable-td"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></td>
        </tr>
      </table>

    </div>
  </div>