<?php
session_start();
$ipage = true;
$title = "profile_card";

//process
require_once("function/function.php");

//header
require_once("sub/header.php");

//content
?>


<div class="container">
    <br>
    <div class="profile-card">
        <div class="photo-column">
            <img src="asset/avatar/photo.png" alt="Profile Photo" class="profile-photo">
        </div>
        <div class="details-column">
            <div class="details-row">
                <div class="details-item">
                    <h3>Name</h3>
                    <p>John Doe</p>
                </div>
                <div class="details-item">
                    <h3>Age</h3>
                    <p>30</p>
                </div>
                <div class="details-item">
                    <h3>Location</h3>
                    <p>New York, USA</p>
                </div>
            </div>
            <div class="details-row">
                <div class="details-item">
                    <h3>Profession</h3>
                    <p>Software Engineer</p>
                </div>
                <div class="details-item">
                    <h3>Experience</h3>
                    <p>8 Years</p>
                </div>
                <div class="details-item">
                    <h3>Education</h3>
                    <p>MSc Computer Science</p>
                </div>
            </div>
        </div>
        <div class="qr-code-column">
            <h3>SCAN QR CODE TO REPORT THIS PERSON LOCATION</h3>
            <img src="asset/qr/005_file_6dbf00849cde9668e8c68eed5761e10f.png" alt="QR Code" class="qr-code">
        </div>
    </div>

</div>

<?php

require_once("sub/footer.php");
?>