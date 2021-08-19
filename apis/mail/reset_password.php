<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
include "../db.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/opt/lampp/htdocs/facebook/PHPMailer/src/Exception.php';
require '/opt/lampp/htdocs/facebook/PHPMailer/src/SMTP.php';
require '/opt/lampp/htdocs/facebook/PHPMailer/src/PHPMailer.php';

$email = $_POST['email'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";
$resetPassword = 'password';
$newPassword = password_hash($resetPassword, PASSWORD_DEFAULT);

if ($email) {
  try {
    $getUserSql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $db->prepare($getUserSql);
    $stmt->execute([$newPassword, $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $getUserSql = "SELECT firstname, lastname FROM users WHERE email = ?";
    $stmt = $db->prepare($getUserSql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fristname = $result['firstname'];
    $lastname = $result['lastname'];
    $username = $fristname . ' ' . $lastname;
    $message = 'New password is: ' . $resetPassword . '. You need to update your password';
    
    $mail = new PHPMailer(TRUE);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.sendgrid.net';
      $mail->SMTPAuth = TRUE;
      $mail->SMTPSecure = 'tls';
      $mail->Username = 'apikey';
      $mail->Password = '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';
      $mail->Port = 587;

      $mail->setFrom('hangpham120398@gmail.com', 'admin-system-hangpham');
      $mail->addAddress($email, $username);
      $mail->Subject = 'Email With Reset Password';
      $mail->Body = $message;

      if (!$mail->send())
      {
        echo $mail->ErrorInfo;
      }
      header("Location: ../../../facebook/reset_password.php?success=1");
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  } catch (PDOException $e) {
   echo $e->getMessage(); 
  }
} else {
  echo "Email is required";
}


