<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("location: index.php");
}

include "utils/header.php";
?>
<link type="text/css" rel="stylesheet" href="assets/css/home.css" />
<?php 
include "utils/navigation.php";
include "utils/friend_list.php";
?>

<ul id='list-chat-windows'
  style='position: fixed; bottom: 84px; z-index: 100000; overflow: auto; display: flex; flex-direction: row; flex-wrap: wrap-reverse; right: 230px; margin: 0;'>
</ul>
<div class='row' style='margin-top: 85px;' id='detail-wrapper-background'>
  <div id='detail-avatar' class="col-md-3">
  </div>
</div>
<div class="row">
  <div class="col-md-3"></div>
  <div id='detail-post-content' class='col-md-6'></div>
  <div class='col-md-3'></div>
</div>
  <script src="./handlers/homeHandler.js"></script>
  <script src='./handlers/detailHandler.js'></script>
<?php


include "utils/footer.php";
?>
