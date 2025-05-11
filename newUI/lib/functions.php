<?php
if (!isset($_SESSION)) {
    session_start();
}
require __DIR__.'/../php/dbh.php';

function getUserInfo()
{
    global $dbh;
    global $aes;
    $user_id = $_SESSION["userid"];
    $stmt = $dbh->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $decrypted_pwd = $aes->decrypt($result['users_pwd'], $_SESSION["password"]);

    $user = [
      'user_id' => $result['user_id'],
      'users_name' => $result['users_name'],
      'users_email' => $result['users_email'],
      'pwd' => $decrypted_pwd
    ];

    return $user;
}

function checkVerification()
{
    global $dbh;
    $user_id = $_SESSION["userid"];
    $stmt = $dbh->prepare("SELECT isVerified FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $isVerified = $stmt->fetch(PDO::FETCH_ASSOC)['isVerified'];

    return $isVerified;
}