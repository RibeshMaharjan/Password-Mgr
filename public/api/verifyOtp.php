<?php
require_once __DIR__ . '/../php/dbh.php';

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
if (!isset($data->otp) || empty(trim($data->otp))) {
    echo json_encode(["success" => false, "message" => "OTP is required"]);
    exit;
}

$otp = trim($data->otp);
$email = trim($data->email);

// Verify OTP
try {
    global $dbh;

    // Find user by OTP
    $stmt = $dbh->prepare('SELECT u.user_id, u.users_email, a.otp, a.otp_expiry_date 
                          FROM auth_settings a 
                          JOIN users u ON a.user_id = u.user_id 
                          WHERE a.otp = ? AND (u.users_email = ? OR u.users_name = ?);');
    $stmt->execute([$otp, $email, $email]);;

    if ($stmt->rowCount() <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid OTP"]);
        exit;
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $userId = $result['user_id'];
    $userEmail = $result['users_email'];
    $otpExpiryDate = $result['otp_expiry_date'];

    // Check if OTP has expired (15 minutes timeout)
    if (time() - strtotime($otpExpiryDate) > 900) {
        echo json_encode(["success" => false, "message" => "OTP has expired"]);
        exit;
    }

    // Generate token
    $token = bin2hex(random_bytes(32));

    // Store token in database
    $stmt = $dbh->prepare("UPDATE users SET token = ? WHERE user_id = ?");
    $stmt->execute([$token, $userId]);

    // Clear OTP after successful verification
    $stmt = $dbh->prepare("UPDATE auth_settings SET otp = NULL WHERE user_id = ?");
    $stmt->execute([$userId]);

    // Start session and set auth variable (for web compatibility)
    session_start();
    $_SESSION["userid"] = $userId;
    $_SESSION['auth'] = true;

    // Return success response with token and email
    echo json_encode([
        "success" => true, 
        "message" => "OTP verified successfully", 
        "token" => $token,
        "email" => $userEmail
    ]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}
