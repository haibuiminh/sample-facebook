<?php
header('Content-Type: application/json');
include "../db.php";

$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$birthday = $_POST['birthday'];
$gender = $_POST['gender'];
$userImage = "default.png";
$coverDefault = "default_cover.jpg";
$describeDefault = "Hello $firstName";
$statusDefault = "no_verify";

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($firstName && $lastName && $email && $password && $birthday && $gender) {
  try {
    $sql = "INSERT INTO users (firstname, lastname, email, password, user_describe, birthday, user_image, gender, cover, status)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $userSelectSql = "SELECT id, firstname, lastname, email FROM users WHERE email = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email, password_hash($password, PASSWORD_DEFAULT), $describeDefault, $birthday, $userImage, $gender, $coverDefault, $statusDefault]);
    $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare($userSelectSql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($result);
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


