<?php
require_once '../helpers/session_helper.php';
require_once './dbh.php';
require_once '../lib/aes.php';
require_once '../lib/sendMail.php';

$aes = new AES();

if (isset($_POST['login'])) {
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

if (isset($_POST['register'])) {
    unset($_SESSION['formError']);
    unset($_SESSION['error']);

    $fullname = trim($_POST['fullname']);
    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if (!empty($fullname) || !empty($uname) || !empty($email) || !empty($password) || !empty($confirmPassword)) {

        $_SESSION['uname'] = $uname;
        $_SESSION['email'] = $email;

        validateFullName($fullname);
        validateEmail($email);
        validateUsername( $uname);
        validatePassword($password, $confirmPassword);

        if(isset($_SESSION['formError'])) {
            header('Location: ./../signup.php');
            exit();
        }

       try {
            // generate random 6 digit verification code
            $verificationCode = mt_rand(100000, 999999);

            $dbh->beginTransaction();
            $stmt = $dbh->prepare('INSERT INTO users (users_fullname, users_name, users_email, users_pwd, users_salt) VALUES (?,?,?,?,?);');
            $salt = openssl_random_pseudo_bytes(24);
            $iterations = 10000;
            $keyLength = 24;
            $key = hash_pbkdf2("sha256", $password, $salt, $iterations, $keyLength, true);

            $encypted_pwd = $aes->encrypt($password, $key);

            $stmt->execute(array($fullname, $uname, $email, $encypted_pwd, $key));
            $userId = $dbh->lastInsertId();

            $stmt = $dbh->prepare('INSERT INTO auth_settings (user_id, verification_code, verification_req_date) VALUES (?,?,CURRENT_TIMESTAMP);');
            $stmt->execute(array($userId, $verificationCode));
            $dbh->commit();

            $_SESSION['success'] = 'Registration Successful. Please verify your email.';
            sendVerificationMail($email, $verificationCode);

            unset($_SESSION['formError']);
            unset($_SESSION['error']);
            unset($_SESSION['uname']);
            unset($_SESSION['email']);
            unset($_SESSION['fullname']);

            echo "<meta http-equiv='refresh' content='0;url=../login.php'>";
            exit();
        } catch (PDOException $e) {
            $dbh->rollBack();
            echo "Error: " . $e->getMessage();
            $_SESSION['error'] = 'Failed to register. Please try again later.\n'. $e->getMessage();
            header('Location: ./../signup.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Please fill all fields.';
        header('Location: ./../signup.php');
        exit();
    }
}

function validateFullName(String $fullName): void {
    // Replace multiple spaces with a single space
    $fullName = preg_replace('/\s+/', ' ', $fullName);
    $_SESSION['fullname'] = $fullName;

    // Check if empty
    if (empty($fullName)) {
        $_SESSION['formError']['fullname'] = "Full name is required.";
        return;
    }

    // Check length
    if (strlen($fullName) < 3) {
        $_SESSION['formError']['fullname'] = "Full name must be at least 3 characters.";
        return;
    }

    // Check format: only letters, spaces, hyphens, apostrophes
    if (!preg_match("/^[a-zA-Z\s]+$/", $fullName)) {
        $_SESSION['formError']['fullname'] = "Full name can only contain letters, spaces.";
        return;
    }
}

function validateEmail(String $email): void
{
    global $dbh;

    if (empty($email)) {
        $_SESSION['formError']['email'] = "Email is required.";
        return;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['formError']['email'] = 'Invalid email.';
        return;
    }

    try {
        $stmt = $dbh->prepare('SELECT * FROM users WHERE users_email = ?;');
        $stmt->execute(array($email));
    } catch (PDOException $pdoerror) {
        echo $pdoerror->getMessage();
        $_SESSION['error'] = 'Internal Server Error. Please try again later.'. $pdoerror->getMessage();
        header('Location: ./../signup.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Failed to register. Please try again later.';
        header('Location: ./../signup.php');
        exit();
    }

    if($stmt->rowCount() > 0) {
        $_SESSION['formError']['email'] = 'Email already exist.';
    }
}

function validateUsername(String $username): void
{
    global $dbh;

    if (empty($username)) {
        $_SESSION['formError']['uname'] = "Username is required.";
        return;
    }

    if (strlen($username) < 3 || strlen($username) > 50) {
        $_SESSION['formError']['uname'] = "Username must be between 3 and 50 characters.";
        return;
    }

    if(!preg_match("/^[a-zA-Z0-9_-]*$/", $username)) {
        $_SESSION['formError']['uname'] = 'Full name can only contain letters, numbers, hyphens and underscores.';
        return;
    }

    try {
        $stmt = $dbh->prepare('SELECT * FROM users WHERE users_name = ?;');
        $stmt->execute(array($username));
    } catch (PDOException $pdoerror) {
        echo $pdoerror->getMessage();
        $_SESSION['error'] = 'Internal Server Error. Please try again later.'. $pdoerror->getMessage();
        header('Location: ./../signup.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Failed to register. Please try again later.';
        header('Location: ./../signup.php');
        exit();
    }

    if($stmt->rowCount() > 0) {
       $_SESSION['formError']['uname'] = 'Username already exist.';
    }
}

/**
 * @param String $password
 * @param String $confirmPassword
 * @return void
 */
function validatePassword(String $password, String $confirmPassword): void
{
    if (empty($password)) {
        $_SESSION['formError']['password'] = "Password cannot be empty.";
        return;
    }

    if (empty($confirmPassword)) {
        $_SESSION['formError']['confirmPassword'] = "Confirm password cannot be empty.";
        return;
    }

    if (strlen($password) < 8) {
        $_SESSION['formError']['password'] = "Password must be at least 8 characters.";
        return;
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $_SESSION['formError']['password'] = "Password must contain at least 1 uppercase letter.";
        return;
    }

    if (!preg_match('/[a-z]/', $password)) {
        $_SESSION['formError']['password'] = "Password must contain at least 1 lowercase letter.";
        return;
    }

    if (!preg_match('/[0-9]/', $password)) {
        $_SESSION['formError']['password'] = "Password must contain at least 1 number.";
        return;
    }

    if (!preg_match('/[@$!%*#?&]/', $password)) {
        $_SESSION['formError']['password'] = "Password must contain at least 1 special character.";
        return;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['formError']['confirmPassword'] = "Passwords do not match.";
    }
    return;
}

header('Location: ./../login.php');
exit();
?>