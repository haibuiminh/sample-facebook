<?php
header('Content-Type: application/json');
include "../db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($email && $password) {
  try {
    $updatePassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$updatePassword, $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    


    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($email);
  } catch (PDOException $e) {
    $res = $e->getMessage();
    $statusHeader = "HTTP/1.1 " . $badRequestStatus . " " . getStatusCodeMeeage($badRequestStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($e->getMessage());
  }
  
} else {
  $statusHeader = "HTTP/1.1 " . $badRequestStatus . " " . getStatusCodeMeeage($badRequestStatus);
  header($statusHeader);
  header('Content-Type: ' . $contentType);
  echo json_encode(null);
}


