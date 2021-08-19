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
  <form id="identicalForm" class="form-horizontal"
    data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

    <div class="form-group">
      <label class="col-sm-3 control-label" style='color: black;'>Password</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" name="password" id='input-password1'
          data-bv-identical="true"
          data-bv-identical-field="confirmPassword"
          data-bv-identical-message="The password and its confirm are not the same" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" style='color:black;'>Retype password</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" name="confirmPassword"
          id='input-password2'
          data-bv-identical="true"
          data-bv-identical-field="password"
          data-bv-identical-message="The password and its confirm are not the same" />
      </div>
    </div>
    <div class='form-group'>
      <button type='button' id='update-password-btn' class='btn btn-primary' style='margin-left: 20px;'>Update Password</button>
    </div>
  </form>
</div>
<script src="./handlers/updatePasswordHandler.js"></script>

<div id="valid-change-toast"
  style="position: absolute; left: 0; bottom: 100px; z-index: 1000000;"
  class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
  <div class="toast-header">
    <strong class="mr-auto">OK</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Change Password successfully
  </div>
</div>
<?php


include "utils/footer.php";
?>
