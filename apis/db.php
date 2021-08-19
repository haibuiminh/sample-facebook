<?php
include "../httpStatus.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db_name = "facebook";
$db_server = "127.0.0.1";
$db_user = "root";
$db_pass = "";

$db = new PDO("mysql:host={$db_server};dbname={$db_name};charset=utf8", $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
