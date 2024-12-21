<?php

require_once __DIR__.'/../dbh.php';

class Login {

    public function getUser($uname, $pwd) {
        global $dbh;
        $stmt = $dbh->prepare('SELECT users_salt FROM users WHERE users_name = ? OR users_email = ?;');

        if(!$stmt->execute(array($uname, $uname))) {
            $stmt = null;
            header("location: ../public/login.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../public/login.php?error=usernotfound");
            exit();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate Salt key
        $salt = $row[0]["users_salt"];

        // Check if password is correct
        $stmt = $dbh->prepare('SELECT AES_DECRYPT(users_pwd, ?) AS decrypted_password FROM users WHERE users_name = ? OR users_email = ?');
        if(!$stmt->execute(array($salt, $uname, $uname))) {
            $stmt = null;
            header("location: ../public/login.php?error=stmtfailed");
            exit();
        }
    
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../public/login.php?error=usernotfound");
            exit();
        }
        
        $decryptPwd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = ($pwd == $decryptPwd[0]['decrypted_password']) ? true : false;

        // If password is incorrect
        if($checkPwd == false) {
            $stmt = null;
            header("location: ../public/login.php?error=wrongpassword");
            exit();
        }
        elseif($checkPwd == true) {
            $stmt = $dbh->prepare('SELECT * FROM users WHERE (users_name = ? OR users_email = ?) AND users_pwd = AES_ENCRYPT(?,?);');

            if(!$stmt->execute(array($uname, $uname, $pwd, $salt))) {
                $stmt = null;
                header("location: ../public/login.php?error=stmtfailed");
                exit();
            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../public/login.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION['auth'] = true;
            $_SESSION["userid"] = $user[0]["user_id"];
            $_SESSION["username"] = $user[0]["users_name"];
            $_SESSION["password"] = $user[0]["users_salt"];
        }
        $stmt= null;
    }
}