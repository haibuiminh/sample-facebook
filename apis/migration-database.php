<?php
include "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

function migrationDatabase($db) {
  $sqlUserTable = "CREATE TABLE users(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(400) NOT NULL,
    user_describe VARCHAR(255) NULL, 
    birthday TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_image VARCHAR(255) NULL,
    gender VARCHAR(6) NOT NULL,
    cover VARCHAR(255) NULL,
    register_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status VARCHAR(255) NULL
  )";
  
  $sqlRelationTable = "CREATE TABLE relations(
    user_id1 INT NOT NULL, 
    user_id2 INT NOT NULL,
    befriend_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_relations PRIMARY KEY (user_id1, user_id2)
  )";
  
  $sqlPostTable = "CREATE TABLE posts(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    content VARCHAR(255) NOT NULL,
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) 
  )";
  
  $sqlPostImageTable = "CREATE TABLE post_images(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_image VARCHAR(255) NOT NULL,
    post_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) 
  )";
  
  $sqlCommentTable = "CREATE TABLE comments(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    comment VARCHAR(255) NOT NULL,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES posts(id)
  )";
  
  $sqlCommentImageTable = "CREATE TABLE comment_images(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comment_image VARCHAR(255) NOT NULL,
    comment_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (comment_id) REFERENCES comments(id)
  )";
  
  $sqlMessageTable = "CREATE TABLE messages(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id_from INT UNSIGNED NOT NULL,
    user_id_to INT UNSIGNED NOT NULL,
    message VARCHAR(255) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    isSeen BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (user_id_from) REFERENCES users(id),
    FOREIGN KEY (user_id_to) REFERENCES users(id)
  )";
  
  $sqlMessageImageTable = "CREATE TABLE message_images(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_image VARCHAR(255) NOT NULL,
    message_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (message_id) REFERENCES messages(id)
  )";
  try {
    $db->exec($sqlUserTable);
    $db->exec($sqlRelationTable);
    $db->exec($sqlPostTable);
    $db->exec($sqlPostImageTable);
    $db->exec($sqlCommentTable);
    $db->exec($sqlCommentImageTable);
    $db->exec($sqlMessageTable);
    $db->exec($sqlMessageImageTable);
  } catch (\PDOException $e) {
    echo $e->getMessage();
    return false;
  }
  return true;
}

if (migrationDatabase($db)) {
  echo "Migration data successful!";
}
