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

    $getPostSql = "SELECT DISTINCT p.id, u.firstname, u.lastname, u.email, u.user_image, p.content, p.post_date, pimg.post_image
      FROM users as u
      JOIN posts as p 
      ON u.id=p.user_id 
      LEFT JOIN post_images as pimg
      ON pimg.post_id = p.id
      LEFT JOIN relations as r
      ON r.user_id1 = u.id OR r.user_id2 = u.id
      WHERE u.email = ? OR u.id IN ( SELECT u1.id FROM relations as r1
                                        JOIN users as u1 ON (r1.user_id1 = u1.id OR r1.user_id2 = u1.id) AND (r1.user_id1 = ? OR r1.user_id2 = ?)
                                        WHERE u1.email != ?)
      ORDER BY p.post_date DESC";
    $stmt = $db->prepare($getPostSql);
    $stmt->execute([$email, $userId, $userId, $email]);
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
