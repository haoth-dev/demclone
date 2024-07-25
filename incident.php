<?php
session_start();
$ipage = true;
$title = "Incident";

//process
require_once("function/function.php");
$incObj = new incident();



//header
require_once("sub/header.php");

//content
?>


<div class="container">

    <div class="form-floating row">
        <div class="col-2">
            <a href="nav_page.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
        </div>
    </div>
    <h4>Incident</h4>

    <nav>
        <div class="nav nav-tabs" id="inc-tab" role="tablist">
            <button class="nav-link" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="false">All</button>
            <button class="nav-link" id="nav-inprogress-tab" data-bs-toggle="tab" data-bs-target="#nav-inprogress" type="button" role="tab" aria-controls="nav-inprogress" aria-selected="false">In Progress</button>
            <button class="nav-link" id="nav-resolved-tab" data-bs-toggle="tab" data-bs-target="#nav-resolved" type="button" role="tab" aria-controls="nav-resolved" aria-selected="false">Resolved </button>
            <button class="nav-link" id="nav-cancelled-tab" data-bs-toggle="tab" data-bs-target="#nav-cancelled" type="button" role="tab" aria-controls="nav-cancelled" aria-selected="false">Cancelled </button>

        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

            <?php
            $incList = $incObj->list_all_inc($_SESSION['pcd_email']);
            $incObj->table_inc_filtered_list($incList);
            ?>
        </div>
        <div class="tab-pane fade" id="nav-inprogress" role="tabpanel" aria-labelledby="nav-inprogress-tab">
            <?php
            $incInProgressList = $incObj->list_filtered_inc_by_status('In-Progress', $_SESSION['pcd_email']);
            $incObj->table_inc_filtered_list($incInProgressList);
            ?>

        </div>

        <div class="tab-pane fade" id="nav-resolved" role="tabpanel" aria-labelledby="nav-resolved-tab">
            <?php
            $incResolvedList = $incObj->list_filtered_inc_by_status('Resolved', $_SESSION['pcd_email']);
            $incObj->table_inc_filtered_list($incResolvedList);
            ?>

        </div>
        <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab">
            <?php
            $incCancelledList = $incObj->list_filtered_inc_by_status('Cancelled', $_SESSION['pcd_email']);
            $incObj->table_inc_filtered_list($incCancelledList);
            ?>

        </div>
    </div>



    <br>
    <a href="incident_add.php" class="btn btn-primary floating-button">
        <i class="fas fa-plus"></i>
    </a>


</div>

<script>
    function manageTabs() {
        // Get all tab buttons
        const tabButtons = document.querySelectorAll('#inc-tab button');
        const tabContent = document.querySelectorAll('.tab-pane');

        // Get the active tab from local storage
        const activeTab = localStorage.getItem('incidentActiveTab');

        // If there is an active tab in local storage, set it as active
        if (activeTab) {
            tabButtons.forEach(button => {
                if (button.id === activeTab) {
                    button.classList.add('active');
                    document.querySelector(button.getAttribute('data-bs-target')).classList.add('show', 'active');
                } else {
                    button.classList.remove('active');
                }
            });
        } else {
            // Default to the first tab
            tabButtons[0].classList.add('active');
            tabContent[0].classList.add('show', 'active');
        }

        // Add click event listeners to each tab button
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to the clicked button
                button.classList.add('active');

                // Hide all tab content
                tabContent.forEach(content => content.classList.remove('show', 'active'));
                // Show the clicked tab content
                document.querySelector(button.getAttribute('data-bs-target')).classList.add('show', 'active');

                // Save the active tab to local storage
                localStorage.setItem('incidentActiveTab', button.id);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', manageTabs);
</script>

<?php

require_once("sub/footer.php");
?>