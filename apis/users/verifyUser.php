<?php
header('Content-Type: application/json');
include "../db.php";
include "../../queries/users/index.php";


$email = $_POST['email'];
$password = $_POST['password'];

$defaultStatus = 201;
$badRequestStatus = 403;
$contentType = "application/json";

if ($email && $password) {
  try {
    $isVerify = verifyUser($email, $password, $db);
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($isVerify);
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


