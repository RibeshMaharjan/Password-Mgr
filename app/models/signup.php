<!-- All the DB related task like running query -->
<?php

require_once __DIR__.'/../dbh.php';

class Signup{

    protected function setUser($uname, $email, $pwd) {
        global $dbh;
        
        $stmt = $dbh->prepare('INSERT INTO users (users_name, users_email, users_pwd, users_salt) VALUES (?,?,AES_ENCRYPT(?,?),?);');

        // Generate keu for user
        $salt = openssl_random_pseudo_bytes(24);
        $iterations = 10000;
        $keyLength = 24;
        $key = hash_pbkdf2("sha256", $pwd, $salt, $iterations, $keyLength, true);

        if(!$stmt->execute(array($uname, $email, $pwd, $key, $key))) {
            $stmt = null;
            header("location: ../public/login.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }

    protected function checkUser($uname, $email) {
        global $dbh;

        $stmt = $dbh->prepare('SELECT users_name FROM users WHERE users_name = ? OR users_email = ?;');

        if(!$stmt->execute(array($uname, $email))) {
            $stmt = null;
            header("location: ../public/login.php?error=stmtfailed");
            exit();
        }
        
        $resultCheck = true;
        
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        }

        return $resultCheck;
    }
}