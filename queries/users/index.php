<?php 
  function verifyUser($email, $password, $db) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $passwordHash = $result['password'];
    $isVerify = password_verify($password, $passwordHash);
    return $isVerify;
  }
?>