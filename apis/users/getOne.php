<?php
header('Content-Type: application/json');
include "../db.php";

$id = (int) $_GET['id'];

$stmt = $db->prepare("SELECT * FROM users WHERE ID = ?");
$stmt->execute([$id]);
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
