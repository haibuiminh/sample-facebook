<?php
header('Content-Type: application/json');
include "../db.php";


$emailFrom = $_GET['emailFrom'];
$emailTo = $_GET['emailTo'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($emailFrom && $emailTo) {
  try {
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

    $getMessageSql = "SELECT m.id, m.user_id_from, m.user_id_to, m.message, m.createdAt, mi.message_image 
      FROM messages as m
      LEFT JOIN message_images as mi ON m.id = mi.message_id
      WHERE user_id_from = ? OR user_id_to = ? OR user_id_from = ? OR user_id_to = ?
      ORDER BY m.createdAt DESC";
    $stmt = $db->prepare($getMessageSql);
    $stmt->execute([$userSendId, $userRecieveId, $userRecieveId, $userSendId]);
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


