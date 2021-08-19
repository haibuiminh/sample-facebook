<?php
header('Content-Type: application/json');
include "../db.php";

$sql = "SELECT * FROM users";
$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);