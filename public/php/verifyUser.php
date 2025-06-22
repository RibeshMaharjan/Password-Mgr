<?php

require_once '../helpers/session_helper.php';
require_once './dbh.php';

if (isset($_POST['verify'])) {
    unset($_POST['verify']);
    $verificationCode = $_POST['verification_code'];

    if ($verificationCode == '') {
        $_SESSION['error'] = 'Please enter verification code.';
        header('Location: ./../emailVerification.php');
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

    if ($verificationCode != $userVerificationCode) {
        $_SESSION['error'] = 'Wrong verification code.';
        header('Location: ./../emailVerification.php');
        exit();
    } else if (time() - strtotime($verifyReqDate) > 900) {
        $_SESSION['error'] = 'Verification code expired.';
        header('Location: ./../emailVerification.php');
        exit();
    }

    $stmt = $dbh->prepare("UPDATE auth_settings SET `isVerified` = '1', `verification_code` = NULL, `verification_req_date` = NULL WHERE user_id = ?;");
    $stmt->execute(array($_SESSION["userid"]));

    $_SESSION['message'] = 'Verification Successful.';

    header('Location: ./../emailVerification.php');
    exit();
}

if (isset($_POST['verify_otp'])) {
    unset($_POST['verify_otp']);
    $otp_code = $_POST['otp_code'];

    if ($otp_code == '') {
        $_SESSION['error'] = 'Please enter verification code.';
        header('Location: ./../2FA.php');
        exit();
    }

    $stmt = $dbh->prepare('SELECT otp, otp_expiry_date FROM auth_settings WHERE user_id = ?');
    $stmt->execute(array($_SESSION["userid"]));

    if ($stmt->rowCount() <= 0) {
        $_SESSION['error'] = 'User does not exists.';
        header('Location: ./../login.php');
        exit();
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $userOtpCode = $result['otp'];
    $verifyReqDate = $result['otp_expiry_date'];

    if ($otp_code != $userOtpCode) {
        $_SESSION['error'] = 'Wrong OTP code.';
        header('Location: ./../2FA.php');
        exit();
    } else if (time() - strtotime($verifyReqDate) > 30) {
        $_SESSION['error'] = 'Verification code expired.';
        header('Location: ./../2FA.php');
        exit();
    }

    $_SESSION['message'] = 'Login Successful.';

    if($_SESSION['error'] == '') {
        $_SESSION['auth'] = true;
    }

    header('Location: ./../dashboard.php');
    exit();
}
?>