<?php
header('Content-Type: application/json');
include "../db.php";

$searchKey = $_GET['search'];
$currentUserEmail = $_GET['currentUserEmail'];

$defaultStatus = 200;
$contentType = "application/json";
if ($currentUserEmail) {
  $sql = "SELECT id FROM users WHERE email = ?";
  $stmt = $db->prepare($sql);
  $stmt->execute([$currentUserEmail]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $currentUserId = $result['id'];
}

if (empty($searchKey)) {
  $sql = "SELECT u1.id, u1.firstname, u1.lastname, u1.email, u1.user_image FROM users as u1
    WHERE u1.id NOT IN ( SELECT id FROM users as u2 JOIN relations as r ON u2.id = r.user_id1 OR u2.id = r.user_id2 WHERE r.user_id1 = ? OR r.user_id2 = ?)
  ";
  $stmt = $db->prepare($sql);
  $stmt->execute([$currentUserId, $currentUserId]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if ($result) {
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($result);
  } else {
    $statusHeader = "HTTP/1.1 404 " . getStatusCodeMeeage(404);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode(null);
  }
} else {
  $sql = "SELECT id, firstname, lastname, email, user_image FROM users WHERE email = ? OR firstname = ? or lastname = ? AND email != ?";
  $stmt = $db->prepare($sql);
  $stmt->execute([$searchKey, $searchKey, $searchKey, $currentUserEmail]);
  $result = $stmt->fetchAll((PDO::FETCH_ASSOC));
  if ($result) {
    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($result);
  } else {
    $statusHeader = "HTTP/1.1 404 " . getStatusCodeMeeage(404);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode(null);
  }
}