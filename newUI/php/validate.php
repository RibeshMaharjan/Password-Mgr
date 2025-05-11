<?php

require_once '../helpers/session_helper.php';
require_once './dbh.php';
require_once '../lib/aes.php';

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
            $checkPwd = ($password == $decryptPwd['users_pwd']) ? true : false;

            if($checkPwd) {
                $stmt = $dbh->prepare('SELECT * FROM users WHERE (users_name = ? OR users_email = ?) AND users_pwd = ?;');
                $stmt->execute(array($uname, $uname, $password));
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['auth'] = true;
                $_SESSION["userid"] = $user["user_id"];
                $_SESSION["username"] = $user["users_name"];
                $_SESSION["email"] = $user["users_email"];
                $_SESSION["password"] = $user["users_salt"];

                $_SESSION['success'] = 'Login Successful. Welcome!';
                header('Location: ./../dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Wrong password. Please try again.';
                header('Location: ./../login.php');
                exit();
            }
        } else {
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