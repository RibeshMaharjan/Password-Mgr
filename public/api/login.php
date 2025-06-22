<?php
/**
 * API Login Endpoint
 * 
 * This endpoint handles user authentication for the API.
 * It supports both regular login and 2FA authentication.
 */
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

// Initialize AES encryption
$aes = new AES();

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->email, $data->password)) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$uname = trim($data->email);
$pwd = trim($data->password);

// Authenticate user
try {
    global $dbh;

    // Fetch user data with a single query
    $stmt = $dbh->prepare('SELECT u.*, a.is_2FA_enabled 
                          FROM users u 
                          LEFT JOIN auth_settings a ON u.user_id = a.user_id 
                          WHERE u.users_name = ? OR u.users_email = ?');

    if (!$stmt->execute([$uname, $uname])) {
        echo json_encode(["success" => false, "message" => "Database error"]);
        exit;
    }

    if ($stmt->rowCount() == 0) {
        echo json_encode(["success" => false, "message" => "User not found"]);
        exit;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    $salt = $user["users_salt"];
    $encryptedPassword = $aes->encrypt($pwd, $salt);

    if ($encryptedPassword !== $user['users_pwd']) {
        echo json_encode(["success" => false, "message" => "Wrong password"]);
        exit;
    }

    // Handle 2FA if enabled
    if ($user['is_2FA_enabled'] == 1) {
        $otp_code = mt_rand(100000, 999999);

        try {
            $stmt = $dbh->prepare('UPDATE auth_settings SET
                                  otp = ?,
                                  otp_expiry_date = CURRENT_TIMESTAMP
                                  WHERE user_id = ?');
            $stmt->execute([$otp_code, $user['user_id']]);

            sendOTPMail($user['users_email'], $otp_code, $user["users_name"]);
            echo json_encode([
                "success" => true, 
                "is2FAEnabled" => true, 
                "message" => "OTP code sent to your email"
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                "success" => false, 
                "message" => "Failed to send OTP. Please try again later."
            ]);
            exit;
        }
    }

    // For non-2FA users, generate and store token
    $token = bin2hex(random_bytes(32));

    $stmt = $dbh->prepare("UPDATE users SET token = ? WHERE user_id = ?");
    $stmt->execute([$token, $user["user_id"]]);

    echo json_encode([
        "success" => true, 
        "token" => $token,
        "email" => $user["users_email"]
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false, 
        "message" => "Server error: " . $e->getMessage()
    ]);
}
