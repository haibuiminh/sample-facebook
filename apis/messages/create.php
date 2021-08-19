<?php
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

$emailFrom = $_POST['emailFrom'];
$emailTo = $_POST['emailTo'];
$message = $_POST['message'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($emailFrom && $emailTo && ($message || !empty($_FILES['image']))) {
  try {
    $db->beginTransaction();

    $getUserSendSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($getUserSendSql);
    $stmt->execute([$emailFrom]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userSendId = $result['id'];

    $getUserRecieveSql = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($getUserRecieveSql);
    $stmt->execute([$emailTo]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userRecieveId = $result['id'];

    $createMessageSql = "INSERT INTO messages (user_id_from, user_id_to, message) VALUES(?, ?, ?)";
    $stmt = $db->prepare($createMessageSql);
    $stmt->execute([$userSendId, $userRecieveId, $message]);
    $stmt->fetch(PDO::FETCH_ASSOC);    
    $messageId = $db->lastInsertId();

    
    if (!empty($_FILES['image'])) {
      $imageName = generateRandomString() . $_FILES['image']['name'];
      $extension = explode('.', $_FILES['image']['name']);
      $extension = $extension[(count($extension) - 1)]; 
      
      if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
        move_uploaded_file($_FILES['image']['tmp_name'], '../../messageImages/' . $imageName);
        $sql = "INSERT INTO message_images (message_id, message_image) VALUES(?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$messageId, $imageName]);
        $stmt->fetch(PDO::FETCH_ASSOC);
      }
    }
    $db->commit();
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($messageId);
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


