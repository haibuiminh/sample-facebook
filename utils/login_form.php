<?php 
  include 'apis/db.php';
  include 'queries/users/index.php';

  if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isVerify = verifyUser($email, $password, $db);
    if ($isVerify) {
      $_SESSION['email'] = $email;
      header("location: home.php");
    }
  } 

?>
<form id='login-form' method="POST" action="" name='login'>
  <div id='form1' class='fb-header'>Email or Phone<br/>
    <input id='login-email' type="mail" name="email" placeholder="Email" /><br/>
    <input type="checkbox" />Keep me logged in
  </div>

  <div id='form2' class='fb-header'>Password<br/>
    <input id='login-password' placeholder="Password" type="password" name="password" /><br/>
    <a style='color: white;' href='reset_password.php'>Forgotten your password?</a>
  </div>
  <button type="button" class='submit1' value='login' name='login' onclick="validationLoginForm()">Login</button>
  <script src="./handlers/loginValidation.js"></script>
</form>
