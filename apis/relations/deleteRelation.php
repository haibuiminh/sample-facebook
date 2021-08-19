<?php
header('Content-Type: application/json');
include "../db.php";

$emailView = $_POST['emailView'];
$emailOwner = $_POST['emailOwner'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($emailView && $emailOwner) {
  try {
    $sqlGetUserView = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($sqlGetUserView);
    $stmt->execute([$emailView]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userViewId = $result['id'];

    $sqlGetUserOwner = "SELECT id FROM users WHERE email = ?";
    $stmt = $db->prepare($sqlGetUserOwner);
    $stmt->execute([$emailOwner]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userOwnerId = $result['id'];

    $sql = "DELETE FROM relations WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userViewId, $userOwnerId, $userOwnerId, $userViewId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $statusHeader = "HTTP/1.1 " . $defaultStatus . " " . getStatusCodeMeeage($defaultStatus);
    header($statusHeader);
    header('Content-Type: ' . $contentType);
    echo json_encode($userViewId . $userOwnerId);
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


