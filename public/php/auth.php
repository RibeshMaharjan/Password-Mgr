<?php

require_once __DIR__.'/../helpers/session_helper.php';
require __DIR__.'/dbh.php';
require __DIR__.'/../lib/sendMail.php';;

if(isset($_POST['send_disable_mail'])) {
    $verificationCode = mt_rand(100000,999999);

    try {
        $stmt = $dbh->prepare('UPDATE auth_settings SET
                                    verification_code = ?,
                                    verification_req_date = CURRENT_TIMESTAMP
                                    WHERE user_id = ?;
                                ');
        $stmt->execute(array($verificationCode, $_SESSION['userid']));

        sendVerificationMail($_SESSION['email'], $verificationCode);

        $_SESSION['success'] = 'Verification code sent to your email.';
        header('Location: ../disable2FA.php');
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        $_SESSION['error'] = 'Failed to disable 2FA. Please try again later.';
        header('Location: ../profile.php');
        exit();
    }
}

if(isset($_POST['send_enable_mail'])) {
    $verificationCode = mt_rand(100000,999999);

    try {
        $stmt = $dbh->prepare('UPDATE auth_settings SET
                                            verification_code = ?,
                                        verification_req_date = CURRENT_TIMESTAMP
                                        WHERE user_id = ?;
                                ');
        $stmt->execute(array($verificationCode, $_SESSION['userid']));

        sendVerificationMail($_SESSION['email'], $verificationCode);
        $_SESSION['success'] = 'Verification code sent to your email.';
        header('Location: ../enable2FA.php');
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        $_SESSION['error'] = 'Failed to enable 2FA. Please try again later.';
        header('Location: ../profile.php');
        exit();
    }
}

if(isset($_POST['enable_2FA'])) {
    $verification_code = $_POST['verification_code'];

    if ($verification_code == '') {
        $_SESSION['error'] = 'Please enter verification code.';
        header('Location: ../enable2FA.php');
        exit();
    }

    $stmt = $dbh->prepare('SELECT verification_code, verification_req_date FROM auth_settings WHERE user_id = ?');
    $stmt->execute(array($_SESSION["userid"]));

    if ($stmt->rowCount() <= 0) {
        $_SESSION['error'] = 'User does not exists.';
        header('Location: ./../login.php');
        exit();
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $userVerificationCode = $result['verification_code'];
    $verifyReqDate = $result['verification_req_date'];

    if ($verification_code != $userVerificationCode) {
        $_SESSION['error'] = 'Wrong verification code.';
        header('Location: ../enable2FA.php');
        exit();
    } else if (time() - strtotime($verifyReqDate) > 900) {
        $_SESSION['error'] = 'Verification code expired.';
        header('Location: ../enable2FA.php');
        exit();
    }

    try {
        $stmt = $dbh->prepare("UPDATE auth_settings SET `is_2FA_enabled` = '1', `verification_code` = NULL, `verification_req_date` = NULL WHERE user_id = ?;");
        $stmt->execute(array($_SESSION["userid"]));
        $_SESSION['success'] = '2FA Enabled.';
        header("location: ../profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = '2FA could not be enabled. Please try again.';
        header("location: ../profile.php");
        exit();
    }

    header("location: ../profile.php");
    exit();
}

if(isset($_POST['disable_2FA'])) {
    $verification_code = $_POST['verification_code'];

    if ($verification_code == '') {
        $_SESSION['error'] = 'Please enter verification code.';
        header('Location: ../disable2FA.php');
        exit();
    }

    $stmt = $dbh->prepare('SELECT verification_code, verification_req_date FROM auth_settings WHERE user_id = ?');
    $stmt->execute(array($_SESSION["userid"]));

    if ($stmt->rowCount() <= 0) {
        $_SESSION['error'] = 'User does not exists.';
        header('Location: ./../login.php');
        exit();
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $userVerificationCode = $result['verification_code'];
    $verifyReqDate = $result['verification_req_date'];

    if ($verification_code != $userVerificationCode) {
        $_SESSION['error'] = 'Wrong verification code.';
        header('Location: ../disable2FA.php');
        exit();
    } else if (time() - strtotime($verifyReqDate) > 900) {
        $_SESSION['error'] = 'Verification code expired.';
        header('Location: ../disable2FA.php');
        exit();
    }

    try {
        $stmt = $dbh->prepare("UPDATE auth_settings SET `is_2FA_enabled` = '0', `verification_code` = NULL, `verification_req_date` = NULL WHERE user_id = ?;");
        $stmt->execute(array($_SESSION["userid"]));
        $_SESSION['error'] = '2FA Disabled.';
        header("location: ../profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $_SESSION['error'] = '2FA could not be disabled. Please try again.';
        header("location: ../profile.php");
        exit();
    }

    header("location: ../profile.php");
    exit();
}