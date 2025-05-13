<?php

include_once __DIR__.'/dbh.php';
require_once __DIR__.'/../helpers/session_helper.php';
include_once __DIR__.'/../lib/functions.php';

require_once __DIR__.'/../lib/aes.php';

$aes = new AES();

if (isset($_POST['updateProfile'])) {
    // Grabbing the data
//        $saltKey = $_SESSION["password"];
    $user_id = $_POST["userid"];
    $fullname = $_POST["fullname"];
    $uname = $_POST["username"];
    $email = $_POST["email"];
//        $pwd = $_POST["password"];

//        $encypted_pwd = $aes->encrypt($pwd, $saltKey);

    if(empty($fullname) || empty($uname) || empty($email)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("location: ../profile.php");
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("location: ../profile.php");
        exit;
    }

    if(strlen($uname) < 3) {
        $_SESSION['error'] = "Username must be at least 3 characters.";
        header("location: ../profile.php");
        exit;
    }

    try {
        $stmt = $dbh->prepare("UPDATE users SET
                                        users_fullname = :fullname,
                                        users_name = :username,
                                        users_email = :email
                                        WHERE user_id = :user_id");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        $_SESSION['success'] = "Profile updated successfully.";
        header("location: ../profile.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = "Profile could not be updated. Please try again.";
        header("location: ../profile.php");
        exit;
    }
}


if (isset($_POST['changePassword'])) {
// Grabbing the data
    $saltKey = $_SESSION["password"];
    $user_id = $_SESSION["userid"];
    $pwd = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $newPasswordConfirm = $_POST["confirmPassword"];


    if(empty($pwd) || empty($newPassword) || empty($newPasswordConfirm)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("location: ../profile.php");
        exit;
    }

    $stmt = $dbh->prepare("SELECT users_pwd FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION["userid"]);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $decrypted_pwd = $aes->decrypt($result['users_pwd'], $saltKey);

    if($decrypted_pwd !== $pwd) {
        $_SESSION['error'] = "Current password is incorrect.";
        header("location: ../profile.php");
        exit;
    }

    validateVassword($newPassword, $newPasswordConfirm);

    $encypted_pwd = $aes->encrypt($newPassword, $saltKey);

    try {
        $stmt = $dbh->prepare("UPDATE users SET
                                        users_pwd = :password
                                        WHERE user_id = :user_id");
        $stmt->bindParam(':password', $encypted_pwd);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        $_SESSION['success'] = "Password changed successfully.";
        header("location: ../profile.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = "Password could not be changed. Please try again.";
        header("location: ../profile.php");
        exit;
    }
}