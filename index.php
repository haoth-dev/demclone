<?php
session_start();
$ipage = true;
$title = "LOGIN";

//process
require_once("function/function.php");

if (isset($_SESSION['pcd_email'])) {
  $login = new login($_SESSION['pcd_email']);
  $login->level_navigate();
}

if (isset($_GET['register'])) {
  if ($_GET['register'] == 'success') alert('Register Success, please login with your email and password');
}

if (isset($_POST['login'])) {
  $login = new login();
  $username = $_POST['username'];
  $password = $_POST['password'];
  $login->login_process($username, $password);

  if ($login) {
  } else {
    alert($login->e_log);
  }
}


//header
require_once("sub/header.php");

//content
?>


<div class="container">
  <br>

  <div class="row">
    <div class="container">
      <img src="asset\images\appicon_dark.png" class="rounded float-left" alt="Responsive image" height="150" width="150">
    </div>


    <div class="row">
      <div class="col-md">
        <h3>Welcome back,</h3>
        <p>Caring Beyong Words: Dementia Care with Heart</p>

        <form method='post'>
          <div class="form-group  row">
            <div class="col-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-address-card"></i>
                  </div>
                </div>
                <input id="text" name="username" placeholder="example:user@mail.com" type="text" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-key"></i>
                  </div>
                </div>
                <input id="text1" name="password" type="password" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-12 forgotPassword">
              <a href="<?php echo "forgotpassword.php"; ?>">Forget Password?</a>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <button name="login" type="submit" class="btn btn-primary btn-lg btn-block std-btn">Sign In</button>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-12">
              <a href="register.php" class="btn btn-light btn-lg btn-block std-btn" role="button" aria-pressed="true">Create Account</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>





</div>
<?php

require_once("sub/footer.php");
?>