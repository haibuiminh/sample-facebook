<?php
include "utils/header.php";

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<link type="text/css" rel="stylesheet" href="assets/css/home.css" />

<div class='fb-header row' style='display: flex; flex-direction: row; align-items: center; justify-content: space-between;'>
  <div style="position:absolute; display: flex; align-items: center; margin-left: 40px;">
    <a style='margin-right: 20px; cursor: pointer;' href="/facebook/home.php">
      <img src="assets/images/facebook.png" />
    </a>
</div>
</div>

<div style="margin-top: 90px; color: black;" class="row">
  <div class='col-sm-3'>
  </div>
  <div class='col-sm-6'>
    <form action='apis/mail/reset_password.php' method="POST" id="emailForm" enctype="multipart/form-data">
      <div class="contact-form">
        <?php
        if (!empty($_GET['success']) && $_GET['success']) { ?>
          <div id='message-alert' class='alert alert-success alert-dismissible fade show'>
            Please check your email to get new password
          </div>
        <?php } ?>
        <div class='form-group'>Enter your email to reset password</div>
        <div class='form-group'>
          <label class='control-label col-sm-2' for='email' style='color: black;'>Email*:</label>
          <div class='col-sm-10'>
            <input type='email' class='form-control' id='email' name='email' placeholder="Enter email" style='width: 100%;'/>
          </div>
        </div>
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            <button type='submit' class='btn btn-primary' name='sendEmail'>Reset password</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class='col-sm-3'></div>
</div>

<script src="./handlers/sendMailHandler.js"></script>
<?php
include "utils/footer.php";
?>
