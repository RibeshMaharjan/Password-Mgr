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
    $stmt = $dbh->prepare("SELECT * FROM users u JOIN auth_settings a ON u.user_id = a.user_id WHERE u.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $decrypted_pwd = $aes->decrypt($result['users_pwd'], $_SESSION["password"]);

    $result['pwd'] = $decrypted_pwd;

    return $result;
}

function checkVerification()
{
    global $dbh;
    $user_id = $_SESSION["userid"];
    $stmt = $dbh->prepare("SELECT isVerified FROM auth_settings WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $isVerified = $stmt->fetch(PDO::FETCH_ASSOC)['isVerified'];

    return $isVerified;
}