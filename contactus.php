<?php
session_start();
$ipage = true;
$title = "Contact Us";

// Include the PHPMailer library and the custom mail function
require_once 'function/function.php';

// Process the form submission
$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subject = 'New Contact Us Message from ' . $name;
        $body = "Name: $name<br>Email: $email<br><br>Message:<br>$message";

        // Send the email using ar_mail2 function
        if (ar_mail2(email_username, $subject, $body)) {  // Replace with your email address
            $message_sent = true;
        } else {
            $message_sent = false;
        }
    } else {
        $message_sent = false;
    }
}

// Header
require_once("sub/header.php");
?>

<div class="container">
    <h2>Contact Us</h2>

    <?php if ($message_sent): ?>
        <div class="alert alert-success" role="alert">
            Your message has been sent successfully!
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="alert alert-danger" role="alert">
            There was an error sending your message. Please ensure all fields are filled out correctly.
        </div>
    <?php endif; ?>

    <form method="POST" action="contactus.php">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="message" name="message" placeholder="Your Message" style="height: 150px;" required></textarea>
            <label for="message">Message</label>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>

<?php
// Footer
require_once("sub/footer.php");
?>
