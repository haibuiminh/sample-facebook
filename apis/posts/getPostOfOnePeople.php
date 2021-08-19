<?php
header('Content-Type: application/json');
include "../db.php";

$email = $_GET['email'];

$defaultStatus = 201;
$badRequestStatus = 400;
$contentType = "application/json";

if ($email) {
  try {
    $getPostSql = "SELECT DISTINCT p.id, u.firstname, u.lastname, u.email, u.user_image, p.content, p.post_date, pimg.post_image
      FROM users as u
      JOIN posts as p 
      ON u.id=p.user_id
      JOIN post_images as pimg
      ON pimg.post_id = p.id
      WHERE u.email = ? OR u.id = r.user_id2 OR u.id = r.user_id1
      ORDER BY p.post_date DESC";
    $stmt = $db->prepare($getPostSql);
    $stmt->execute([$email]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
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
