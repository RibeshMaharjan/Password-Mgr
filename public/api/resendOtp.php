<?php

require_once __DIR__ . '/../php/dbh.php';
require_once __DIR__ . '/../lib/sendMail.php';
require_once __DIR__ . '/../lib/aes.php';

// Set headers for JSON response
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->email)) {
    echo json_encode(["success" => false, "message" => "Email or Username is required"]);
    exit;
}

$email = trim($data->email);

$verificationCode = mt_rand(100000, 999999);

try{
  $getID = $dbh->prepare('SELECT user_id, users_name, users_email FROM users WHERE users_name = ? OR users_email = ?');
  $getID->execute(array($email, $email));
  $userInfo = $getID->fetch();

  $stmt = $dbh->prepare('UPDATE auth_settings SET
                                  otp = ?,
                                  otp_expiry_date = CURRENT_TIMESTAMP
                                  WHERE user_id = ?;
                          ');

  $stmt->execute(array($verificationCode, $userInfo['user_id']));

  sendOTPMail($userInfo['users_email'], $verificationCode, $userInfo['users_name']);

  // Return success response with token and email
  echo json_encode([
    "success" => true,
    "message" => "OTP send successfully",
  ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}
