<?php
//Load Composer's autoloader
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/opt/lampp/htdocs/facebook/PHPMailer/src/Exception.php';
require '/opt/lampp/htdocs/facebook/PHPMailer/src/SMTP.php';
require '/opt/lampp/htdocs/facebook/PHPMailer/src/PHPMailer.php';


if ($_POST['email']) {
  $userReceiveEmail = $_POST['email'];
  echo $userReceiveEmail . "\n";
  $name = $_POST['uname'];
  $toEmail = $_POST['email'];
  $message = $_POST['message'];
  
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
    $mail->addAddress($userReceiveEmail, $name);
    $mail->Subject = 'Email With Attachment';
    $mail->Body = $message;

    if ($_FILES['attachFile']) {
      $mail->addAttachment($_FILES['attachFile']['tmp_name'], $_FILES['attachFile']['name']);
    }
    if (!$mail->send())
    {
      /* PHPMailer error. */
      echo $mail->ErrorInfo;
    }
    header("Location: ../../../facebook/send_mail.php?success=1");
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
?>