<?php
session_start();
include "utils/header.php";
?>

<div class='fb-header'>
  <div id="img1" class='fb-header'>
    <img src="assets/images/facebook.png" />
  </div>
  <?php include "utils/login_form.php"; ?>
</div>

<div class='fb-body'>
  <?php
    include "utils/register_form.php";  
    include "utils/toast.php";
  ?>
</div>
<?php 
  include "utils/footer.php";
?>
