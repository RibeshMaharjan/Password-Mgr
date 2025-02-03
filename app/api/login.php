<?php
require_once __DIR__ . '/../dbh.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email, $data->password)) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$uname = $data->email;
$pwd = $data->password;

// Fetch user from DB
global $dbh;
$stmt = $dbh->prepare('SELECT users_salt FROM users WHERE users_name = ? OR users_email = ?;');

if (!$stmt->execute(array($uname, $uname))) {
    $stmt = null;
    echo json_encode(["success" => false, "message" => "Statement failed"]);
}

if ($stmt->rowCount() == 0) {
    $stmt = null;
    echo json_encode(["success" => false, "message" => "User Not Found"]);
}

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate Salt key
$salt = $row[0]["users_salt"];

// Check if password is correct
$stmt = $dbh->prepare('SELECT AES_DECRYPT(users_pwd, ?) AS decrypted_password FROM users WHERE users_name = ? OR users_email = ?');

if (!$stmt->execute(array($salt, $uname, $uname))) {
    $stmt = null;
    echo json_encode(["success" => false, "message" => "Statement failed"]);
}

if ($stmt->rowCount() == 0) {
    $stmt = null;
    echo json_encode(["success" => false, "message" => "User Not Found"]);
}

$decryptPwd = $stmt->fetchAll(PDO::FETCH_ASSOC);
$checkPwd = ($pwd == $decryptPwd[0]['decrypted_password']) ? true : false;

// If password is incorrect
if ($checkPwd == false) {
    $stmt = null;
    echo json_encode(["success" => false, "message" => "Wrong Password"]);
} else {
    $stmt = $dbh->prepare('SELECT * FROM users WHERE (users_name = ? OR users_email = ?) AND users_pwd = AES_ENCRYPT(?,?);');

    if (!$stmt->execute(array($uname, $uname, $pwd, $salt))) {
        $stmt = null;
        echo json_encode(["success" => false, "message" => "Statement Failed"]);
    }

    if ($stmt->rowCount() == 0) {
        echo json_encode(["success" => false, "message" => "User Not Found"]);
    }

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $token = bin2hex(random_bytes(32)); // Generate a secure token

    // Store token in DB (for session tracking)
    $stmt = $dbh->prepare("UPDATE users SET token = ? WHERE user_id = ?");
    $stmt->execute([$token, $user[0]["user_id"]]);

    echo json_encode(["success" => true, "token" => $token]);
}
$stmt = null;
