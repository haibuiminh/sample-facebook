<?php
header('Content-Type: application/json');
include "../db.php";

$email = $_GET['email'];

$stmt = $db->prepare("SELECT id, firstname, lastname, email, user_image, cover FROM users WHERE email = ?");
$stmt->execute([$email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$defaultStatus = 200;
$contentType = "application/json";

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
