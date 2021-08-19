<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
include "../db.php";

function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

$email = $_POST['email'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($email && !empty($_FILES['image'])) {
  try {
    $imageName = generateRandomString() . $_FILES['image']['name'];
    $extension = explode('.', $_FILES['image']['name']);
    $extension = $extension[(count($extension) - 1)]; 
    
    if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
      move_uploaded_file($_FILES['image']['tmp_name'], '../../userImages/' . $imageName);
      $sql = "UPDATE users SET user_image = ? WHERE email = ?";
      $stmt = $db->prepare($sql);
      $stmt->execute([$imageName, $email]);
      $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode('Success');
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


