<!-- All the DB related task like running query -->
<?php

class Signup extends Dbh{

    protected function setUser($uname, $email, $pwd) {
        $stmt = $this->connect()->prepare('INSERT INTO users (users_name, users_email, users_pwd, users_salt) VALUES (?,?,AES_ENCRYPT(?,?),?);');

        // $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        // // Convert the hashed password to binary data
        // $binaryPwd = bin2hex($hashedPwd);

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
        $stmt = $this->connect()->prepare('SELECT users_name FROM users WHERE users_name = ? OR users_email = ?;');

        if(!$stmt->execute(array($uname, $email))) {
            $stmt = null;
            header("location: ../public/login.php?error=stmtfailed");
            exit();
        }
        
        $resultCheck = false;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}