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
<div class="row" style="margin-top: 80px">
  <div class='col-sm-2'></div>
	<div id="insert-post" class="col-sm-8">
		<center>
		<form action="" method="POST" id="post-form" enctype="multipart/form-data">
      <textarea class="form-control" id="content" rows="4" name="content" placeholder="What's in your mind?"></textarea><br>
      <label class="btn btn-warning" id="upload-image-button">Select Image
      <input type="file" name="upload-image" size="30" id="file">
      </label>
      <button id="btn-post" class="btn btn-success" name="sub">Post</button>
		</form>

		</center>
  </div>
  <div class='col-sm-2'></div>
</div>
<div id="row-posts" style='margin-top: 20px;'>
  <div class="col-sm-2"></div>
  <div class='col-sm-8'>
    <div class="card" style="margin-top: 10px;">
      <div class='row' style="padding: 20px 40px;" style="align-items: center;">
        <img src="./userImages/default.png" style="height: 40px;" class="mr-4" alt="userImage">
        <h3 style="margin-top: 5px;">Username</h3>
        <div style='margin-top:13px; margin-left: 10px'>12-03=2020</div>
      </div>
      <img src="./cover/cover2.jpg" class="card-img" alt="post1">
    </div>
  </div>
  <div class="col-sm-2"></div>
</div>
  <script src="./handlers/homeHandler.js"></script>
<?php


include "utils/footer.php";
?>
