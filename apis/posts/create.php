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
$content = $_POST['content'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($email && $content) {
  try {
    $db->beginTransaction();

    $getUserSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($getUserSql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $result['id'];

    $createPostSql = "INSERT INTO posts(user_id, content) VALUES(?, ?)";
    $stmt = $db->prepare($createPostSql);
    $stmt->execute([$userId, $content]);
    $stmt->fetch(PDO::FETCH_ASSOC);    
    $postId = $db->lastInsertId();


    if (!empty($_FILES['image'])) {
      $imageName = generateRandomString() . $_FILES['image']['name'];
      $extension = explode('.', $_FILES['image']['name']);
      $extension = $extension[(count($extension) - 1)]; 
      
      if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
        move_uploaded_file($_FILES['image']['tmp_name'], '../../postImages/' . $imageName);
        $sql = "INSERT INTO post_images (post_image, post_id) VALUES(?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$imageName, $postId]);
        $stmt->fetch(PDO::FETCH_ASSOC);
      }
    }
    
    $db->commit();
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($postId);
  } catch (PDOException $e) {
    $db->rollBack();
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


