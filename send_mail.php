<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("location: index.php");
}

include "utils/header.php";
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<link type="text/css" rel="stylesheet" href="assets/css/home.css" />
<?php 
include "utils/navigation.php";
?>

<div style="margin-top: 90px; color: black;">
  <form action='apis/mail/index.php' method="POST" id="emailForm" enctype="multipart/form-data">
    <div class="contact-form">
      <?php
      if (!empty($_GET['success']) && $_GET['success']) { ?>
        <div id='message-alert' class='alert alert-success alert-dismissible fade show'>
          The message has been sent.
        </div>
      <?php } ?>
      <div class='form-group'>
        <label class='control-label col-sm-2' for='fname' style='color: black;'>
          Name*:
        </label>
        <div class='col-sm-10'>
          <input type='text' class='form-control' id='uname' name='uname' placeholder="Enter Name" />
        </div>
      </div>
      <div class='form-group'>
        <label class='control-label col-sm-2' for='email' style='color: black;'>Email*:</label>
        <div class='col-sm-10'>
          <input type='email' class='form-control' id='email' name='email' placeholder="Enter email" style='width: 100%;'/>
        </div>
      </div>
      <div class='form-group'>
        <label class='control-lael col-sm-2' for='lname' style='color: black; display: inherit;'>Attach File:</label>
        <div class='col-sm-10'>
          <input type='file' class='form-control' id='attachFile' name='attachFile' style='display: inherit;'>
        </div>
      </div>
      <div class='form-group'>
        <label class='control-label col-sm-2' for="comment" style='color: black;'>Message*:</label>
        <div class='col-sm-10'>
          <textarea class='form-control' rows="5" name='message' id='message'></textarea>
        </div>
      </div>
      <div class='form-group'>
        <div class='col-sm-offset-2 col-sm-10'>
          <button type='submit' class='btn btn-primary' name='sendEmail'>Send Email</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script src="./handlers/sendMailHandler.js"></script>
<?php


include "utils/footer.php";
?>
