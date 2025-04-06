<?php

require __DIR__.'/../php/dbh.php';

function getUserInfo()
{
    global $dbh;
    $user_id = $_SESSION["userid"];
    $stmt = $dbh->prepare("SELECT *,AES_DECRYPT(users_pwd, :salt_key) AS decrypted_password FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':salt_key', $_SESSION["password"]);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}