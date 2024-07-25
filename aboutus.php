<?php
session_start();
$ipage = true;
$title = "About Us";

// Process
require_once("function/function.php");

// Header
require_once("sub/header.php");

// Content
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>About Us</h2>
            <p class="lead">Welcome to DementiaBN, where we are dedicated to providing the best care and support for individuals living with dementia.</p>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-4 text-center">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h3 class="card-title mb-3">Our Mission</h3>
                    <p class="card-text">Our mission is to enhance the quality of life for people living with dementia and their families through compassionate care, innovative programs, and community education.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h3 class="card-title mb-3">Our Vision</h3>
                    <p class="card-text">We envision a world where dementia is understood and effectively managed, and where individuals with dementia are treated with dignity and respect.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <h3 class="card-title mb-3">Our Team</h3>
                    <p class="card-text">Our team consists of dedicated professionals who are passionate about making a difference in the lives of those affected by dementia. We are committed to providing personalized care and support to meet the unique needs of each individual.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-6 offset-md-3 text-center">
            <h3 class="mb-3">Contact Information</h3>
            <p>If you have any questions or need more information, please don't hesitate to contact us.</p>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> <a href="mailto:dementianbn@dementiabn.xyz">dementianbn@dementiabn.xyz</a></li>
                <li><strong>Phone:</strong> +673-8847636</li>
                <li><strong>Address:</strong> KIGS QIULAP</li>
            </ul>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-6 offset-md-3 text-center">
            <h3 class="mb-3">Follow Us</h3>
            <p>Stay connected with us through our social media channels:</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://www.facebook.com/dementiabn" class="btn btn-primary btn-lg">Facebook</a></li>
                <li class="list-inline-item"><a href="https://www.twitter.com/dementiabn" class="btn btn-info btn-lg">Twitter</a></li>
                <li class="list-inline-item"><a href="https://www.instagram.com/dementiabn" class="btn btn-danger btn-lg">Instagram</a></li>
            </ul>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-md-12 text-center">
            <a href="dementiabn.zip" class="btn btn-success btn-lg">Download Our App</a>
        </div>
    </div>
</div>

<?php
require_once("sub/footer.php");
?>
