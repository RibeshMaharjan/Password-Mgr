<?php
require_once __DIR__ . '/../php/dbh.php';
require_once __DIR__ . '/../lib/aes.php';

$aes = new AES();

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

$headers = getallheaders();

if (isset($headers['Authorization'])) {
  $authHeader = $headers['Authorization'];
}

if (!isset($authHeader)) {
  echo json_encode(["success" => false, "message" => "Unauthorized"]);
  exit;
}

$token = str_replace("Bearer ", "", $authHeader);

// Validate token
$stmt = $dbh->prepare("SELECT user_id,users_salt FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo json_encode(["success" => false, "message" => "Invalid token"]);
  exit;
}

// Fetch passwords
$stmt = $dbh->prepare("SELECT c.username, c.password, s.site_url FROM `credentials` c INNER JOIN `sites` s INNER JOIN `users` u on u.user_id = c.users_id AND c.site_id = s.site_id WHERE c.users_id = ?;
");

$stmt->execute([$user["user_id"]]);
$passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($passwords as &$row) {
  $row['password'] = $aes->decrypt($row['password'], $user["users_salt"]);
}
unset($row);

echo json_encode(["success" => true, "passwords" => $passwords]);