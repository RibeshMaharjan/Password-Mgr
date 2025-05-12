<?php

require_once '../helpers/session_helper.php';
require_once './dbh.php';
require_once '../lib/aes.php';
require_once '../lib/sendMail.php';

$aes = new AES();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    if (!empty($uname) && !empty($pwd)) {
        $stmt = $dbh->prepare('SELECT users_salt FROM users WHERE users_name = ? OR users_email = ?;');
        $stmt->execute(array($uname, $uname));

        if ($stmt->rowCount() > 0) {
            $salt = $stmt->fetch(PDO::FETCH_ASSOC)["users_salt"];

            $stmt = $dbh->prepare('SELECT users_pwd FROM users WHERE users_name = ? OR users_email = ?');
            $stmt->execute(array($uname, $uname));

            $decryptPwd = $stmt->fetch(PDO::FETCH_ASSOC);

            $password = $aes->encrypt($pwd, $salt);
            $checkPwd = $password == $decryptPwd['users_pwd'];

            if($checkPwd) {
                $stmt = $dbh->prepare('SELECT * FROM users u LEFT JOIN auth_settings a ON u.user_id = a.user_id WHERE (u.users_name = ? OR u.users_email = ?) AND u.users_pwd = ?;');
                $stmt->execute(array($uname, $uname, $password));
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                print_r($user);

                $_SESSION["userid"] = $user["user_id"];
                $_SESSION["username"] = $user["users_name"];
                $_SESSION["email"] = $user["users_email"];
                $_SESSION["password"] = $user["users_salt"];

                if($user['is_2FA_enabled'] == 1) {
                    $otp_code = mt_rand(100000,999999);

                    try {
                        $stmt = $dbh->prepare('UPDATE auth_settings SET
                                                            otp = ?,
                                                        otp_expiry_date = CURRENT_TIMESTAMP
                                                        WHERE user_id = ?;
                                                ');
                        $stmt->execute(array($otp_code, $_SESSION['userid']));

                        sendOTPMail($_SESSION['email'], $otp_code, $_SESSION["username"]);
                        $_SESSION['success'] = 'OTP code sent to your email.';
                        header('Location: ../2FA.php');
                        exit();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        $_SESSION['error'] = 'Failed to login. Please try again later.';;
                        header('Location: ../login.php');
                        exit();
                    }
                }

                if($user['is_2FA_enabled'] == 0) {
                    $_SESSION['auth'] = true;
                }

                $_SESSION['success'] = 'Login Successful. Welcome!';
                header('Location: ./../dashboard.php');
                exit();
            } else {
                $_SESSION['uname'] = $uname;
                $_SESSION['error'] = 'Wrong password. Please try again.';
                header('Location: ./../login.php');
                exit();
            }
        } else {
            $_SESSION['uname'] = $uname;
            $_SESSION['error'] = 'User does not exits. Please try again.';
            header('Location: ./../login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Please fill all fields.';
        header('Location: ./../login.php');
        exit();
    }
}

header('Location: ./../login.php');
exit();
?>