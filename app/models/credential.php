<?php

// require_once '../config/dbh.php';

class Credential extends Dbh{
    private $conn;
    private $table_name = "credentials";

    public function setCredential($user_id, $site, $username, $password) {
        $stmt = $this->connect()->prepare('SELECT users_salt FROM users WHERE users_id = ?');
        
        if(!$stmt->execute(array($user_id))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate Salt key
        $salt = $row[0]["users_salt"];

        $stmt = $this->connect()->prepare("INSERT INTO ".$this->table_name." (users_id, site, username, password) VALUES (?,?,?,AES_ENCRYPT(?,?));");
        
        if(!$stmt->execute(array($user_id, $site, $username, $password, $salt))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        else {
            $stmt = null;
            header("location: ../index.php?error=CredentialAdded");
            exit();
        }
    }
}