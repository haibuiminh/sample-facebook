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
<div class='row'>
  
  <div class='col-sm-6' id='row-follow-list' style="margin-top: 100px; max-height: 700px; overflow: auto;"></div>
  <div class='col-sm-6' id='row-friends-list' style="margin-top: 100px; max-height: 700px; overflow: auto;"></div>

</div>
  <script src="./handlers/friendListHandler.js"></script>
<?php


include "utils/footer.php";
?>
