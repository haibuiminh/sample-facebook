<?php
header('Content-Type: application/json');
include "../db.php";

$email = $_GET['email'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($email) {
  try {
    $sqlGetUser = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($sqlGetUser);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $result['id'];

    $sql = "SELECT u.id, u.firstname, u.lastname, u.email, u.user_image FROM relations as r
     JOIN users as u ON (r.user_id1 = u.id OR r.user_id2 = u.id) AND (r.user_id1 = ? OR r.user_id2 = ?)
     WHERE u.email != ? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userId, $userId, $email]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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


