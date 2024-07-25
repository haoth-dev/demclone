<?php
session_start();
$ipage = true;
$title = "Activity";

//process
require_once("function/function.php");
//view_array($_SESSION);

//header
require_once("sub/header.php");

//content
?>

<div class="container">
   <h4>Activity</h4>
   <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">Home</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Content for Home</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Content for Profile</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Content for Contact</div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContent = document.querySelectorAll('.tab-pane');

    function setActiveTab(tabId) {
        navLinks.forEach(link => {
            const isSelected = (link.id === tabId);
            link.classList.toggle('active', isSelected);
            link.setAttribute('aria-selected', isSelected);
            const targetId = link.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            if (target) {
                target.classList.toggle('show', isSelected);
                target.classList.toggle('active', isSelected);
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            localStorage.setItem('activeTab', this.id);
            setActiveTab(this.id);
        });
    });

    const activeTabId = localStorage.getItem('activeTab');
    if (activeTabId) {
        setActiveTab(activeTabId);
    } else {
        setActiveTab('nav-home-tab'); // Default to first tab if none is stored
    }
});
</script>

<?php

require_once("sub/footer.php");
?>
